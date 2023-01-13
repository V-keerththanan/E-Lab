<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    .responsive-div {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 80px;
 

}



.search-container {
  
  display: flex;
  align-items: center;

}

input[type="text"] {
  padding: 10px;
  width:450px;
  border: none;
  font-size: 16px;
  flex-grow: 1;
}

button[type="submit"] {
  padding: 10px;
  background-color: transparent;
  border: none;
}

i.fa-search {
  font-size: 18px;
  color: #333;
}

@media screen and (max-width: 768px) {
  .search-container {
    flex-wrap: nowrap; /* keep the form elements on the same line */
  }
  input[type="text"] {
    width: 80%; /* reduce the width of the input field */
  }
  button[type="submit"] {
    width: 20%; /* reduce the width of the button */
  }
}

</style>
    
</head>
<body>
<div class="responsive-div">
 
  <form class="search-container">
  <input type="text" placeholder="Search...">
  <button type="submit">
    <i class="fa fa-search"></i>
  </button>
</form>

</div>

</body>
</html>