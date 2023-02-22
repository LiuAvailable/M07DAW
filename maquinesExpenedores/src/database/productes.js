const DB = require("./db.json");
const { saveToDatabase } = require("./utils.js");

const getAllProducts = () => {
    return DB.Producte;
};
const getProduct = (idProduct) => {
    return DB.Producte.find(p => p.nom === idProduct);
}
const addProduct = (newProduct) => {
    try {
      const isAlreadyAdded =
        DB.Producte.findIndex((producte) => producte.nom === newProduct.nom) > -1;
      if (isAlreadyAdded) {
        throw {
          status: 400,
          message: `Product with the name '${newProduct.nom}' already exists`,
        };
      }
      DB.Producte.push(newProduct);
      saveToDatabase(DB);
      return newProduct;
    } catch (error) {
      throw { status: error?.status || 500, message: error?.message || error };
    }
};

const modifyProduct = (newProduct) => {
  const indexForUpdate = DB.Producte.findIndex(
    (producte) => producte.nom === newProduct.nom
  );
  if (indexForUpdate === -1) {
    return;
  }
  DB.Producte[indexForUpdate] = newProduct;
  saveToDatabase(DB);
  return updatedWorkout;
};

module.exports = { 
    getAllProducts,
    getProduct,
    addProduct,
    modifyProduct
};