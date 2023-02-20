const producte = require("../database/productes");

const getAllProducts = () => {
    const allProducts = producte.getAllProducts();
    return allProducts;
};

const getProduct = (idProducte) => {
    const product = producte.getProduct(idProducte);
    return product;
}

module.exports = {
    getAllProducts,
    getProduct
};