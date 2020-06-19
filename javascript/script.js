
//Creates "result" that displays a hash
function addResult(i, location, name, hash, likes, dislikes) { //addResult(3, "featured", "Batman.mp4", "h35g2uy5t23v5v3t2yu52", 10, 1)
  var resultLocation = document.getElementById('"' + location + '"'); //Location

  //Main div
  var resultDiv = document.createElement("div");
  resultDiv.classList.add("result");
  resultDiv.id = "result" + location + i;
  resultLocation.appendChild(resultDiv);

  //Info Div
  var hashInfoDiv = document.createElement("div");
  hashInfoDiv.classList.add("hash-info");
  hashInfoDiv.id = "hash-info" + location + i;
  resultDiv.appendChild(hashInfoDiv);

  //Name Div
  var nameDiv = document.createElement("div");
  nameDiv.classList.add("name");
  nameDiv.id = "name" + location + i;
  nameDiv.innerHTML = '"' + name + '"'; //Retrive from DB
  hashInfoDiv.appendChild(nameDiv);

  //Hash Div
  var hashDiv = document.createElement("div");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash" + location + i;
  hashDiv.innerHTML = '"' + hash + '"'; //Retrive from DB
  hashInfoDiv.appendChild(hashDiv);

  //Score Div
  var scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score" + location + i;
  scoreDiv.innerHTML = likes + "/" + dislikes; //Retrive from DB
  resultDiv.appendChild(scoreDiv);
}
