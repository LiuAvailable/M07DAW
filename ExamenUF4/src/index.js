const express = require("express"); 
const v1Router = require("./v0.1/routes");
const bodyParser = require('body-parser');

const app = express(); 
const PORT = process.env.PORT || 3000; 

app.use(bodyParser.json());
app.use("/api/v0.1", v1Router);

app.listen(PORT, () => {
  console.log(`API is listening on port ${PORT}`);
});