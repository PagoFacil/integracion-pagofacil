import './pagoFacil3ds';

let form = document.querySelector('form#3ds')
form.onsubmit = function(event) {
    let form3ds = new PagoFacil3ds(PagoFacil3ds.sandbox);
    form3ds.buildForm();
}