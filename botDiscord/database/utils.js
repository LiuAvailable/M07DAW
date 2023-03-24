const fs = require("fs");

const saveToDatabase = (DB) => {
  console.log(DB)
  fs.writeFileSync("./database/students.json", JSON.stringify(DB, null, 2), {
    encoding: "utf-8",
  });
};

module.exports = { saveToDatabase };