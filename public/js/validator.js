class Validator {
    constructor(form) {
        this.patterns = {
            name: /^[A-Za-zА-Яа-я]+$/,
            lastname: /^[A-Za-zА-Яа-я]+$/,
            login: /[A-Za-z0-9]/,
            phone: /^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/,
            email: /^[\w.-_]+@\w+\.\w{2,4}$/,
            password: /^\w{4,}$/,
            password2: new RegExp("^"+ $('#password').val() +"$")
        };
        this.errors = {
            name: 'Имя содержит только буквы',
            lastname: 'Фамилия содержит только буквы',
            phone: 'Телефон подчиняется шаблону +7(000)000-00-00',
            login: 'Логин содержит буквы латинского алфавита и цифры',
            password: 'Длина пароля минимум 4 символа',
            password2: 'Пароль повторно введен неверно',
            email: 'E-mail выглядит как mymail@mail.ru, или my.mail@mail.ru, или my-mail@mail.ru'
        };
        this.errorClass = 'error-msg';
        this.form = form;
        this._clearErrors();
        this._validateForm(this.form);
        this.flag = $('.invalid');
    }
    _validateForm(form){
        let formFields = [...document.getElementById(form).getElementsByTagName('input')];
        for (let field of formFields){
            this._validate(field);
        }
    }
    _validate(field){
        if (this.patterns[field.name]){
            if (!this.patterns[field.name].test(field.value)){
                field.classList.add('invalid');
                this._addErrorMsg(field);
                this._watchField(field);
            }
        }
    }
    _watchField(field){
        field.addEventListener('input', () => {
            if (this.patterns[field.name].test(field.value)){
                field.classList.remove('invalid');
                field.classList.add('valid');
                if (field.parentNode.lastChild !== field){
                    field.parentNode.lastChild.remove();
                }
            } else {
                field.classList.remove('valid');
                field.classList.add('invalid');
                if (field.parentNode.lastChild.nodeName !== 'DIV'){
                    this._addErrorMsg(field);
                }

            }
        })
    }
    _addErrorMsg(field){
        let errMsg = document.createElement('div');
        errMsg.classList.add(this.errorClass);
        errMsg.textContent = this.errors[field.name];
        field.parentNode.appendChild(errMsg);
    }
    _clearErrors(){
        $(`.${this.errorClass}`).remove();
        $('.invalid').removeClass(['invalid']);
    }
}