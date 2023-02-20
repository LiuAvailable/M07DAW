const producte = require("../database/productes");

const getAllProducts = () => {
    const allProducts = producte.getAllProducts();
    return allProducts;
};

const getProduct = (idProducte) => {
    const product = producte.getProduct(idProducte);
    return product;
}

const addProduct = (newProduct) => {
    try {
        const createdProduct = producte.addProduct(newProduct);
        return createdProduct;
    } catch (error) {
        throw error;
    }
}

module.exports = {
    getAllProducts,
    getProduct,
    addProduct
};