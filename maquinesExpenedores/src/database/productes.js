const DB = require("./db.json");

const getAllProducts = () => {
    return DB.Producte;
};
const getProduct = (idProduct) => {
    return DB.Producte.find(p => p.nom === idProduct);
}

module.exports = { 
    getAllProducts,
    getProduct
};