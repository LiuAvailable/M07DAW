
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

module.exports = {
    getProductes,
    getProducte
};