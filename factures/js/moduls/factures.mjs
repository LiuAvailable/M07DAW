export function createJSON(codiFactura){
    let JSONobj = JSON.parse(updateJSON(codiFactura));
    localStorage.setItem(codiFactura, JSON.stringify(JSONobj));
}

function updateJSON(codiFactura){
    let json = '{"productes":[';
    let liElements = document.querySelectorAll("li:not(:nth-child(1)");
    liElements.forEach(li => {
        json = json + '{"codi":"'+li.children[0].textContent+'","nom":"'+li.children[1].textContent+'","quantitat":"'+li.children[2].value+'","preu":"'+li.children[3].textContent+'"},';
    });
    return json.substring(0, json.length-1)+"]}";
}

export function getLastBill(year){
    let billExists = false;
    let lastCode = "0/0";
    for (let i = 0; i < localStorage.length; i++){
        if(localStorage.key(i).includes(year)){
            billExists = true;
            lastCode = isCodeBigger(lastCode, localStorage.key(i))
        }
    }
    if(!billExists) return year+"/1";
    lastCode = lastCode.split("/");
    let num = parseInt(lastCode[1])+1;
    lastCode = lastCode[0]+"/"+num;
    return lastCode;
}

function isCodeBigger(lastCode, newCode){
    if(parseInt(lastCode.replace('/',''))>parseInt(newCode.replace('/',''))) return lastCode;
    else return newCode;
}
