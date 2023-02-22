
const productsService = require("../services/ProductsService");

const getProductes = (req , res) =>{
    const productes = productsService.getAllProducts();
    res.send({ status: "OK", data: productes });
}
const getProducte = (req , res) =>{
    if(req.params.id !== undefined) {
        const productes = productsService.getProduct(req.params.id);
        res.send({ status: "OK", data: productes });
    }else res.send({ status: "ERROR", data:"Falta l'id del producte"})
}
const postProduct = (req, res) => {
    const { body } = req;
    const nom = body.nom;
    const tipus = body.tipus;
    const preu = body.preu;
    const categoria = body.categoria;

    if(nom && categoria && tipus && preu){
        const newProduct = {nom:nom, tipus:tipus, preu:preu, categoria:categoria}
        productsService.addProduct(newProduct);
        try{
            const product = productsService.addProduct(newProduct);
            res.send({status: "OK", data: product});
        }catch(error){
            res
            .status(error?.status || 500)
            .send({ status: "FAILED", data: { error: error?.message || error } });
        }
    }else res.send({ status: "ERROR", data:"Falten dades del producte"})
}

const modifyProduct = (req, res) => {
    const { body } = req;
    const nom = body.nom;
    const tipus = body.tipus;
    const preu = body.preu;
    const categoria = body.categoria;

    if(nom && categoria && tipus && preu){
        const newProduct = {nom:nom, tipus:tipus, preu:preu, categoria:categoria}
        productsService.addProduct(newProduct);
        try{
            const product = productsService.modifyProduct(newProduct);
            res.send({status: "OK", data: product});
        }catch(error){
            res
            .status(error?.status || 500)
            .send({ status: "FAILED", data: { error: error?.message || error } });
        }
    }else res.send({ status: "ERROR", data:"Falten dades del producte"})
}

module.exports = {
    getProductes,
    getProducte,
    postProduct,
    modifyProduct
};