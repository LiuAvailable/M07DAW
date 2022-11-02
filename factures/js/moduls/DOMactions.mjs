import {createJSON, getLastBill} from '../moduls/factures.mjs';

/**
 * GENERAL FUNCTIONS
 * 
 * appendChild -> newHTMLelement(parent, newElement, textContent)
 * textContent -> textContent(element, text)
 * 
 */
function newHTMLelement(parent, newElement, textContent, attributes) {
    let node = document.createElement(newElement);
    if (attributes != null) {
        for (let i = 0; i < attributes.length; i=i+2) {
            node.setAttribute(attributes[i], attributes[i+1]);
        }
    }
    if (textContent != null) node.innerHTML = textContent;
    parent.appendChild(node);
}
function textContent(element, text){
    element.textContent = text;
}

/*END GENERAL FUNCTIONS*/
//----------------------------------------------------------------

//estableix el codi de una factura nova
export function setNewBillCode(){
    let year = new Date().getFullYear();
    let billCode = getLastBill(year)
    textContent(document.querySelector('label[name="codi"]'),billCode);
}
//afageix opcions al tag select
export function setSelectOptions(articles){
    articles.forEach(article => {
        newHTMLelement(document.querySelector('select'), "option", article.nom)
    });
}
//afegeix un article a la llista
export function addArticleToBill(articles){
    let inputQuantitat = ['class','quantitat','type', 'number', 'min', '0','value','1',];
    document.querySelector('#add').addEventListener('click', () => {
        let article = document.querySelector('select').value;
        if(existsAricle(article)){
            articles.forEach(art => { //agafa l'objecte article corresponent al seleccionat a l'HTML
                if(art.nom == article){
                    newHTMLelement(document.querySelector("ul"),"li", null,['class',art.nom])
                    let parent = document.querySelector("li:last-child");
                    newHTMLelement(parent, "label", art.codi);
                    newHTMLelement(parent, "label", art.nom);
                    newHTMLelement(parent, "input", null, inputQuantitat);
                    newHTMLelement(parent, "label", art.preu);
                    newHTMLelement(parent, "label", art.preu);
                    calculateTotal(parent)
                }
            })
            calculTotals();
            createJSON(document.querySelector("label[name='codi']").textContent);
        }
    });
}
//comprova que no hi hagi 2 files amb el mateix article a la factura
function existsAricle(article){
    if(document.querySelector('.'+article)!= undefined){
        alert("Aquest article ja està a la llista!!\nModifica la quantitat");
        return false
    }else return true;
}
// calcula el total de cada Article (per línea no total general)
function calculateTotal(parent){
    let child=parent.children[2]
    child.addEventListener('change', () => {
        if(child.value == 0) parent.remove()
        else {
            parent.children[4].textContent = parent.children[3].textContent*child.value;
        }
        calculTotals();
        createJSON(document.querySelector("label[name='codi'").textContent);
    });
}
//calcula el total sense IVA de tots els productes i l'IVA.
function calculTotals(){
    let liElements = document.querySelectorAll("li:not(:nth-child(1)");
    let total = 0
    liElements.forEach(li => {
        total = total + parseInt(li.children[4].textContent)
    });
    document.getElementById("BI").textContent = total;
    document.getElementById("IVA").textContent = total*21/100;
    document.getElementById("total").textContent = total+(total*21/100);
}


export function recover(){
    document.getElementById("recoverBill").addEventListener("click", () => {
        //eliminar tots els elements de la taula
        document.querySelectorAll("li:not(:nth-child(1)").forEach(li => li.remove());
        //afegir elements facutra recuperada
        let bill = localStorage.getItem(document.querySelector("input[name='recoverBill']").value);
        bill = JSON.parse(bill);
        bill['productes'].forEach(a => {
            let inputQuantitat = ['class','quantitat','type', 'number', 'min', '0','value',a['quantitat']];
            newHTMLelement(document.querySelector("ul"),"li", null,['class',a['nom']])
            let parent = document.querySelector("li:last-child");
            newHTMLelement(parent, "label", a['codi']);
            newHTMLelement(parent, "label", a['nom']);
            newHTMLelement(parent, "input", null, inputQuantitat);
            newHTMLelement(parent, "label", a['preu']);
            newHTMLelement(parent, "label", a['preu']);
            calculateTotal(parent)
        });
        calculTotals();

        //canviar num factura
        document.querySelector("label[name='codi']").textContent =document.querySelector("input[name='recoverBill']").value
    });
}
