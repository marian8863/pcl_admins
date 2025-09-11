<!DOCTYPE html>
<html>
<head>
    <style>
        #text-box {
            display: none;
        }
    </style>
</head>
<body>
<div class="col-md-6 border rounded shadow-sm">
        <form  method="get" action="">
          <div class="form-row">
  
            <div class="form-group col-md-2">
              <input type="radio" id="hin" name="subject" value="hindi" checked onclick="EnableDisableTB()">
              Hindi </div>
            <div class="form-group col-md-5">
              <input type="radio" id="others" name="subject" value="other"  onclick="EnableDisableTB()">
              Other Language </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Other Language</label>
            </div>
            <div class="form-group col-md-6">
              <input type="text" id="otherlan" name="otherLanguage" disabled="disabled"  placeholder="Other Language">
            </div>
          </div>
        </form>
      </div>
    
      <script type="text/javascript">
    function EnableDisableTB() {
        var others = document.getElementById("others");
        var otherlan = document.getElementById("otherlan");
        otherlan.disabled = others.checked ? false : true;
		otherlan.value="";
        if (!otherlan.disabled) {
            otherlan.focus();
        }
    }
</script>
</body>
</html>
