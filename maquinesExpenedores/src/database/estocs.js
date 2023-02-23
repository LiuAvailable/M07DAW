const DB = require("./db.json");
const { saveToDatabase } = require("./utils.js");

const getAllEstocs = () => {
    return DB.Estoc;
};
const getEstoc = (idEstoc) => {
    return DB.Estoc.find(p => p.nom === idEstoc);
}
const addEstoc = (newEstoc) => {
    try {
      const isAlreadyAdded =
        DB.Estoc.findIndex((Estoc) => Estoc.nom === newEstoc.nom) > -1;
      if (isAlreadyAdded) {
        throw {
          status: 400,
          message: `Estoc with the name '${newEstoc.nom}' already exists`,
        };
      }
      DB.Estoc.push(newEstoc);
      saveToDatabase(DB);
      return newEstoc;
    } catch (error) {
      throw { status: error?.status || 500, message: error?.message || error };
    }
};

const modifyEstoc = (newEstoc) => {
  const indexForUpdate = DB.Estoc.findIndex(
    (Estoc) => Estoc.nom === newEstoc.nom
  );
  if (indexForUpdate === -1) {
    return;
  }
  DB.Estoc[indexForUpdate] = newEstoc;
  saveToDatabase(DB);
  return updatedWorkout;
};

const removeEstoc = (nom) => {
  console.log('a')
  const indexForDeletion = DB.Estoc.findIndex(
    (Estoc) => Estoc.nom === nom
  );
  if (indexForDeletion === -1) {
    return;
  }
  console.log(indexForDeletion)
  console.log(DB.Estoc[indexForDeletion])
  DB.Estoc.splice(indexForDeletion, 1);
  saveToDatabase(DB);
}

const getAvailableEstocs = () => {
  return DB.Estoc.filter(estoc => (estoc.venda === 0 || estoc.venda === "") && new Date(estoc.caducitat) > new Date());
}

const getEstocsVenguts = (dia) => {
  return DB.Estoc.filter(estoc => (estoc.venda === dia));
}

module.exports = { 
    getAllEstocs,
    getEstoc,
    addEstoc,
    modifyEstoc,
    removeEstoc,
    getAvailableEstocs,
    getEstocsVenguts
};