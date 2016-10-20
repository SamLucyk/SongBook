</div>
</div>
<script>
   function select(item){
            if (item.value == "none") {
                item.style.color = "#bfbfbf";
            }
            else {
                item.style.color = "#000";
            }
        }

        function inputFocus(i){
            if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
            removeError(i);
        }

        function inputBlur(i){
            if(i.value==""){ i.value=i.defaultValue; i.style.color="#bfbfbf"; }
            removeError(i);
        }     
</script>
</body>
</html>