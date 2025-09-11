<!DOCTYPE html>
<html>
<head>
    <title>Radio Buttons Example</title>
</head>
<body>
    <label>
        <input type="radio" name="choice" id="showTextboxAndCheckbox" checked onclick="showTextboxAndCheckbox()"> Show Textbox and Checkbox
    </label>
    <br>
    <label>
        <input type="radio" name="choice" id="showHiddenTextboxAndDropdown" onclick="showHiddenTextboxAndDropdown()"> Show Hidden Textbox and Dropdown
    </label>
    <br>
    <div >
        <input type="text" id="textboxAndCheckboxContainer" placeholder="Text input">
        <input type="checkbox" id="textboxAndCheckboxContainer"> Check this box
    </div>

        <input type="text" disabled="disabled" id="hiddenTextboxAndDropdownContainer" style="display: none;" value="Hidden Text">
      <div id="hiddenTextboxAndDropdownContainer" style="display: none;">  
        <select >
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    </div>

    <script>
        function showTextboxAndCheckbox() {
            document.getElementById('textboxAndCheckboxContainer').style.display = 'block';
            document.getElementById('hiddenTextboxAndDropdownContainer').style.display = 'none';
        }

        function showHiddenTextboxAndDropdown() {
            document.getElementById('textboxAndCheckboxContainer').style.display = 'none';
            document.getElementById('hiddenTextboxAndDropdownContainer').style.display = 'block';
        }
    </script>
</body>
</html>
