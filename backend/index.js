import express from "express";
import mysql from "mysql2";
import dotenv from "dotenv";
dotenv.config();

const app = express();

//connecting to mysql
const db = mysql.createConnection({
  host: "localhost",
  user: process.env.user,
  password: process.env.password,
  database: "mydb",
});

app.get("/", (req, res) => {
  //sql injection here
  const q = "select * from employees";
  db.query(q, (err, data) => {
    if (err) return res.json(err);
    return res.json(data);
  });
});

db.connect((err) => {
  if (err) {
    console.error("Error connecting to MySQL:", err);
    return;
  }
  console.log("Connected to MySQL database 'mydb'");
});

app.listen(8000, () => {
  console.log("connected to backend");
});
