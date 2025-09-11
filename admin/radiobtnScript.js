function dynInput(cbox) {   
    var elem = document.getElementById(cbox.name);
  
    if (cbox.value == 1) {
      // you press 'Yes'
      if (!elem) {
        // check if you already have your input
        var input = document.createElement("input");
        input.type = "text";
        var div = document.createElement("div");
        div.id = cbox.name;
        div.innerHTML = cbox.title;
        div.appendChild(input);
        document.getElementById("insertinputs").appendChild(div);
      }
    }
    else {
      // you press 'No'
      if (elem) elem.parentElement.removeChild(elem);
    }
  
  } 