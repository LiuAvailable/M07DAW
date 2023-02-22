const estoc = require("../database/estocs");

const getAllEstocs = () => {
    const allEstocs = estoc.getAllEstocs();
    return allEstocs;
};

const getEstoc = (idEstoc) => {
    const estoc = estoc.getEstoc(idEstoc);
    return estoc;
}

const addEstoc = (newEstoc) => {
    try {
        const createdEstoc = estoc.addEstoc(newEstoc);
        return createdEstoc;
    } catch (error) {
        return error;
    }
}
const modifyEstoc = (newEstoc) => {
    try {
        const createdEstoc = estoc.modifyEstoc(newEstoc);
        return createdEstoc;
    } catch (error) {
        return error;
    }
}

const removeEstoc = (nom) => {
    try {
        const createdEstoc = estoc.removeEstoc(nom);
        return createdEstoc;
    } catch (error) {
        return error;
    }
}

module.exports = {
    getAllEstocs,
    getEstoc,
    addEstoc,
    modifyEstoc,
    removeEstoc
};