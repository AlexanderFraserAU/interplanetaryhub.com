
//Creates "result" that displays a hash
function addResult(i, location, name, hash, likes, dislikes) { //addResult(3, "featured", "Batman.mp4", "h35g2uy5t23v5v3t2yu52", 10, 1)
  let resultLocation = document.getElementById(location); //Location

  //Main div
  let resultDiv = document.createElement("div");
  resultDiv.classList.add("result");
  resultDiv.id = "result" + location + i;
  resultLocation.appendChild(resultDiv);

  //Info Div
  let hashInfoDiv = document.createElement("div");
  hashInfoDiv.classList.add("hash-info");
  hashInfoDiv.id = "hash-info" + location + i;
  resultDiv.appendChild(hashInfoDiv);

  //Name Div
  let nameDiv = document.createElement("div");
  nameDiv.classList.add("name");
  nameDiv.id = "name" + location + i;
  nameDiv.innerHTML = name; //Retrive from DB
  hashInfoDiv.appendChild(nameDiv);

  //Hash Div
  let hashDiv = document.createElement("div");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash" + location + i;
  hashDiv.innerHTML = hash; //Retrive from DB
  hashInfoDiv.appendChild(hashDiv);

  //Score Div
  let scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score" + location + i;
  scoreDiv.innerHTML = likes + "/" + dislikes; //Retrive from DB
  resultDiv.appendChild(scoreDiv);
}
