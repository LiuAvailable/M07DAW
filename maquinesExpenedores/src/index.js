// In src/index.js 
const express = require("express"); 
const v1Router = require("./v1/routes");
const bodyParser = require('body-parser');

const app = express(); 
const PORT = process.env.PORT || 3000; 

app.use(bodyParser.json());
app.use("/api/v1", v1Router);

app.listen(PORT, () => {
  console.log(`API is listening on port ${PORT}`);
});