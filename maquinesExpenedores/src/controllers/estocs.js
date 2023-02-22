
const estocsService = require("../services/EstocsService");

const getEstocs = (req , res) =>{
    let estocs;
    if(req.query.disponible !== undefined && req.query.disponible !== null) estocs = estocsService.getAvailableEstocs()
    else if(req.query.venda) estocs = estocsService.getEstocsVenguts(req.query.venda)
    else estocs = estocsService.getAllEstocs();
    res.send({ status: "OK", data: estocs });
}

const getEstoc = (req , res) =>{
    if(req.params.id !== undefined) {
        const estocs = estocsService.getEstoc(req.params.id);
        res.send({ status: "OK", data: estocs });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}

const postEstoc = (req, res) => {
    const { body } = req;
    const nom = body.nom;
    const caducitat = body.caducitat;
    const venda = body.venda;
    const ubicacio = body.ubicacio;

    if(nom && caducitat && venda && ubicacio){
        const newEstoc = {nom:nom, caducitat:caducitat, venda:venda, ubicacio:ubicacio}
        try{
            const estoc = estocsService.addEstoc(newEstoc);
            res.send({status: "OK", data: estoc});
        }catch(error){
            res
            .status(error?.status || 500)
            .send({ status: "FAILED", data: { error: error?.message || error } });
        }
    }else res.send({ status: "ERROR", data:"Falten dades"})
}

const modifyEstoc = (req, res) => {
    const { body } = req;
    const nom = body.nom;
    const caducitat = body.caducitat;
    const venda = body.venda;
    const ubicacio = body.ubicacio;

    if(nom && caducitat && venda && ubicacio){
        const newEstoc = {nom:nom, caducitat:caducitat, venda:venda, ubicacio:ubicacio}
        try{
            const estoc = estocsService.modifyEstoc(newEstoc);
            res.send({status: "OK", data: estoc});
        }catch(error){
            res
            .status(error?.status || 500)
            .send({ status: "FAILED", data: { error: error?.message || error } });
        }
    }else res.send({ status: "ERROR", data:"Falten dades"})
}

const deleteEstoc = (req, res) => {
    if(req.params.id !== undefined) {
        const estocs = estocsService.removeEstoc(req.params.id);
        res.send({ status: "OK", data: estocs });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}

module.exports = {
    getEstocs,
    getEstoc,
    postEstoc,
    modifyEstoc,
    deleteEstoc
};