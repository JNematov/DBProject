import React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";

export default function SignIn() {
  return (
    <div>
      <Box
        component="form"
        sx={{
          "& .MuiTextField-root": {
            display: "flex",
            justifyContent: "center",
            alignItems: "vertically",
            m: 1,
            width: "25ch",
          },
        }}
        noValidate
        autoComplete="off"
      >
        <TextField required id="outlined-required" label="Username" />
        <TextField required id="outlined-required" label="Password" />
        <Button variant="contained">Submit</Button>
      </Box>
    </div>
  );
}
