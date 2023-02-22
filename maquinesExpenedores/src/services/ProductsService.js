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
        return error;
    }
}
const modifyProduct = (newProduct) => {
    try {
        const createdProduct = producte.modifyProduct(newProduct);
        return createdProduct;
    } catch (error) {
        return error;
    }
}

const removeProduct = (nom) => {
    try {
        const createdProduct = producte.removeProduct(nom);
        return createdProduct;
    } catch (error) {
        return error;
    }
}

module.exports = {
    getAllProducts,
    getProduct,
    addProduct,
    modifyProduct,
    removeProduct
};