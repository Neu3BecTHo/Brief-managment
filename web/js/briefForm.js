let questionIndex = 0;

// Данные передаются из PHP через window.briefFormData
const typeFields = window.briefFormData.typeFields || {};
const typeFieldsCodes = window.briefFormData.typeFieldsCodes || {};
const existingQuestions = window.briefFormData.existingQuestions || [];

document.addEventListener('DOMContentLoaded', function() {
    // Загружаем существующие вопросы (при редактировании)
    if (existingQuestions.length > 0) {
        existingQuestions.forEach(q => addQuestion(q));
        document.getElementById('no-questions-msg').style.display = 'none';
    }

    document.getElementById('add-question-btn').addEventListener('click', function() {
        addQuestion();
        document.getElementById('no-questions-msg').style.display = 'none';
    });

    var container = document.getElementById('questions-container');
    var saveBtn = document.getElementById('save-brief-btn');
    var msg = document.getElementById('no-questions-msg');

    if (!container || !saveBtn) return;

    function toggleSaveButton() {
        var count = container.children.length;

        if (count > 0) {
            saveBtn.removeAttribute('disabled');
            if (msg) msg.style.display = 'none';
        } else {
            saveBtn.setAttribute('disabled', 'disabled');
            if (msg) msg.style.display = 'block';
        }
    }

    var observer = new MutationObserver(function(mutations) {
        toggleSaveButton();
    });

    observer.observe(container, { childList: true });

    setTimeout(toggleSaveButton, 100);
});

function checkQuestionsCount() {
    var count = $('#questions-container').children().length;
    var btn = $('#save-brief-btn');
    var msg = $('#no-questions-msg');

    if (count > 0) {
        btn.prop('disabled', false);
        msg.hide();
    } else {
        btn.prop('disabled', true);
        msg.show();
    }
}

var observer = new MutationObserver(function(mutations) {
    checkQuestionsCount();
});

var container = document.getElementById('questions-container');
if (container) {
    observer.observe(container, { childList: true });
}

$(document).ready(function() {
    setTimeout(checkQuestionsCount, 100);
});

function addQuestion(data = null) {
    const container = document.getElementById('questions-container');
    const currentCount = container.querySelectorAll('.question-item').length; // Считаем реальное количество
    const index = questionIndex++;
    
    const question = data ? data.question : '';
    const typeFieldId = data ? data.type_field_id : Object.keys(typeFields)[0];
    const isRequired = data ? data.is_required : false;
    const options = data ? data.options : '';
    
    const html = `
        <div class="card mb-3 question-item" data-index="${index}">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h6 class="mb-0">Вопрос #${currentCount + 1}</h6> <!-- ТУТ ИСПРАВЛЕНИЕ -->
                    <button type="button" class="btn btn-sm btn-danger remove-question-btn">
                        Удалить
                    </button>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Текст вопроса <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" 
                           name="questions[${index}][question]" 
                           value="${escapeHtml(question)}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Тип поля</label>
                        <select class="form-select type-field-select" name="questions[${index}][type_field_id]">
                            ${generateTypeFieldOptions(typeFieldId)}
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3 options-wrapper">
                        <label class="form-label">Варианты (через запятую)</label>
                        <input type="text" class="form-control options-field" 
                               name="questions[${index}][options]" 
                               value="${escapeHtml(options)}"
                               placeholder="Вариант 1, Вариант 2, Вариант 3">
                        <small class="text-muted">Для select, radio, checkbox</small>
                    </div>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" 
                           name="questions[${index}][is_required]" 
                           id="required_${index}" ${isRequired ? 'checked' : ''}>
                    <label class="form-check-label" for="required_${index}">
                        Обязательное поле
                    </label>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    
    const newItem = container.lastElementChild;
    
    newItem.querySelector('.remove-question-btn').addEventListener('click', function() {
        removeQuestion(newItem);
    });
    
    newItem.querySelector('.type-field-select').addEventListener('change', function() {
        toggleOptionsVisibility(newItem, this.value);
    });
    
    toggleOptionsVisibility(newItem, typeFieldId);
}

function removeQuestion(element) {
    element.remove();
    updateQuestionNumbers();
    
    const container = document.getElementById('questions-container');
    if (container.children.length === 0) {
        document.getElementById('no-questions-msg').style.display = 'block';
    }
}

function updateQuestionNumbers() {
    const items = document.querySelectorAll('.question-item');
    items.forEach((item, index) => {
        item.querySelector('h6').textContent = 'Вопрос #' + (index + 1);
    });
}

function toggleOptionsVisibility(questionElement, typeFieldId) {
    const typeId = parseInt(typeFieldId);
    const typeCode = typeFieldsCodes[typeId] ? typeFieldsCodes[typeId].toLowerCase() : '';
    const optionsWrapper = questionElement.querySelector('.options-wrapper');
    
    const noOptionsNeeded = ['text', 'textarea', 'number', 'date', 'email', 'phone', 'color', 'comment'];
    
    if (noOptionsNeeded.includes(typeCode)) {
        optionsWrapper.style.display = 'none';
    } else {
        optionsWrapper.style.display = 'block';
    }
}

function generateTypeFieldOptions(selectedId) {
    let html = '';
    for (const [id, title] of Object.entries(typeFields)) {
        const selected = id == selectedId ? 'selected' : '';
        html += `<option value="${id}" ${selected}>${escapeHtml(title)}</option>`;
    }
    return html;
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}
