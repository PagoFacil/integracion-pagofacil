"use strict";

class PagoFacil3ds {
    urlApi;
    formReference;
    encodeFields;
    body;

    static get produccion(){
        return 'https://pagofacil.net/ws/public/B3DS/Index/index';
    }

    static get sandbox(){
        return 'https://pagofacil.net/st/public/B3DS/Index/index';
    }

    constructor(ambiente){
        this.urlApi = ambiente;
        this.setterAttrs();
    }

    setterAttrs(){
        this.formReference = document.querySelector('form#3ds-form');
        this.formReference.setAttribute('action', this.urlApi);
    }

    buildForm(){
        this.encodeForm();
        this.body = this.formReference.clone();
        this.clearData();
        this.formReference.appendChild(this.buildHiddenInput(this.encodeFields));

    }

    buildHiddenInput(encodeData){
        let element = document.createElement('input');
        element.setAttribute('type', 'hidden');
        element.id = 'txtContenido';
        element.setAttribute('name', 'contenido');
        element.setAttribute('value', encodeData );

        return element;
    }

    encodeForm(){
        let formData = new FormData(this.formReference);
        let urlParams = new URLSearchParams(formData);
        this.encodeFields = btoa(urlParams.toString());
    }

    clearData(){
        this.formReference.reset();
        this.setterAttrs();
    }
}