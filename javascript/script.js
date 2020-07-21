
//Creates "result" that displays a hash
function addResult(i, location, name, hash, file, upvotes, downvotes) { //addResult(3, "featured", "Batman.mp4", "h35g2uy5t23v5v3t2yu52", 10, 1)
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
  let hashDiv = document.createElement("a");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash" + location + i;
  hashDiv.target = "_blank";
  hashDiv.rel = "noopener noreferrer";
  hashDiv.href = "http://127.0.0.1:8080/ipfs/" + hash + "/" + file;
  hashDiv.setAttribute('onclick', `linkViewModal("${name}", "${hash}", "${file}", "${upvotes}", "${downvotes}")`); //
  hashDiv.innerHTML = hash; //Retrive from DB
  hashInfoDiv.appendChild(hashDiv);

  //Score Div
  let scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score" + location + i;
  resultDiv.appendChild(scoreDiv);

  let upvotesText = document.createElement("div");
  upvotesText.classList.add("upvotemain");
  upvotesText.id = "upvotes" + location + i;
  upvotesText.innerHTML = upvotes;
  scoreDiv.appendChild(upvotesText);

  let slashCharacter = document.createElement("div");
  slashCharacter.classList.add("slashmain");
  slashCharacter.innerHTML = "/";
  scoreDiv.appendChild(slashCharacter);

  let downvotesText = document.createElement("div");
  downvotesText.classList.add("downvotemain");
  downvotesText.id = "downvotes" + location + i;
  downvotesText.innerHTML = downvotes;
  scoreDiv.appendChild(downvotesText);
}

function linkViewModal(name, hash, file, upvotes, downvotes) {

  // Get the modal
  let modal = document.getElementById("hashModal");

  modal.style.display = "block";

  let modalContent = document.getElementById("hashModalContent");

  //Name Div
  let nameDiv = document.createElement("div");
  nameDiv.classList.add("name");
  nameDiv.id = "name";
  nameDiv.innerHTML = name; //Retrive from DB
  modalContent.appendChild(nameDiv);

  //Hash Div
  let hashDiv = document.createElement("a");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash";
  hashDiv.innerHTML = hash; //Retrive from DB
  modalContent.appendChild(hashDiv);

  //Score Div
  let scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score";
  modalContent.appendChild(scoreDiv);

  let upvotesText = document.createElement("p");
  upvotesText.classList.add("upvotemodal");
  upvotesText.innerHTML = upvotes;
  scoreDiv.appendChild(upvotesText);

  let slashCharacter = document.createElement("p");
  slashCharacter.classList.add("slashmodal");
  slashCharacter.innerHTML = "/";
  scoreDiv.appendChild(slashCharacter);

  let downvotesText = document.createElement("p");
  downvotesText.classList.add("downvotemodal");
  downvotesText.innerHTML = downvotes;
  scoreDiv.appendChild(downvotesText);

  let link_hash = document.createElement("input"); //Link identfier
  link_hash.classList.add("link_hash");
  link_hash.type = "hidden";
  link_hash.name = "link_hash";
  link_hash.value = hash;
  let hashModalForm = document.getElementById('hashModalForm');
  hashModalForm.appendChild(link_hash);

  // Get the <span> element that closes the modal
  let span = document.getElementsByClassName("close")[0];

  let content = [nameDiv, hashDiv, scoreDiv];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
    removeContent(content);
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
      removeContent(content);
    }
  }
}

function removeContent(content) {
  for (var i = 0; i < content.length; i++) {
    content[i].remove();
  }
}
