const fs = require("fs");

const saveToDatabase = (DB) => {
  fs.writeFileSync("./database/students.json", JSON.stringify(DB, null, 2), {
    encoding: "utf-8",
  });
};

const setConfig = (DB) => {
  fs.writeFileSync("./config.json", JSON.stringify(DB, null, 2), {
    encoding: "utf-8",
  });
};

module.exports = { saveToDatabase, setConfig };