    function format1(n, currency) {
        return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }
    function format2(n, currency) {
       return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    // mathPlus(cutComma(320,343,243.23453),cutComma(3,243.23453));
    function mathPlus(value1,value2)
     {
        var x = Math.round((value1+value2) * 1e12) / 1e12;
        return Number(x.toFixed(2));
    }
    // mathPlus(cutComma(320,343,243.23453),cutComma(3,243.23453));
    function mathMultiply(value1,value2)
     {
        var x = Math.round((value1*value2) * 1e12) / 1e12;
        return Number(x.toFixed(2));
    }
    // mathMinus(cutComma(320,343,243.23453),cutComma(3,243.23453));
    function mathMinus(value1,value2)
     {
        var x = Math.round((value1-value2) * 1e12) / 1e12;
        return Number(x.toFixed(2));
    }
    function rem1000Sep(val){
      return val.replace(/,/g,"");
    }
    function decimalFont(val)
    {   val.toString();
        var decimalData=((val).toString()).indexOf(".");
        if(decimalData==-1)
        {
            decimalData=(val.length);
        }
        return parseFloat((val.toString()).substring(0,decimalData));
    }
    function decimalBack(val)
    {   
        var decimalData=((val).toString()).indexOf(".");
        if(decimalData==-1)
        {
            decimalData=(val.length);
        }
        var lastData=(((val).toString()).length);
        return ((val.toString()).substring(decimalData,lastData));
    }
    function decimalBackTwo(val,decimal)
    {
        return (decimalBack(val)).toString().substring(0,decimal);
    }
    
    //cutComma(1,243.23) = 1243.23
    function cutComma(newValue2)
    {    
        if(newValue2!=(""||null||undefined))
        {
            
             var newValue=newValue2.toString();
             
            if(isNaN(parseFloat(newValue.replace(/,/g,"")))==false)
            {
            
                var dataFont=(decimalFont(parseFloat(rem1000Sep(newValue))));
                
                
                var dataBack=decimalBackTwo(newValue,3);                
                
                //return (parseFloat(dataFont+dataBack)).toFixed(2);
                return (parseFloat(dataFont+dataBack));
            }
            else
            {
                return (newValue);
            }
        }
        else
        {
            
            return "";
        }
    }
    
/*format currency*/
var formatCurrency = function(num){
    var str = num.toString(), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return(formatted + ((parts) ? "." + ((parts[1].length==1)?parts[1].substr(0, 2)+"0":parts[1].substr(0, 2)) : ".00"));
};

var formatCurrencyOnKey = function(number){
    num = number.replace( /[^0-9\.]/g, '' );
    var str = num.toString(), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
var formatNumberAndDecimalOnKey = function(number){
    num = number.replace( /[^0-9\.]/g, '' );
    var str = num.toString(), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 1) {
        parts = str.split(".");
        num = parts[0]+'.'+parts[1];
    }
    return num;
};
var formatNumberOnKey = function(number){
    num = number.replace( /[^0-9\.]/g, '' );
    var str = num.toString(), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 1) {
        parts = str.split(".");
        num = parts[0];
    }
    return num;
};

$(document).on('keyup', '.currency', function() {
    $(this).val(formatCurrencyOnKey($(this).val()));
});
$(document).on('keyup', '.number_decimal', function() {
    $(this).val(formatNumberAndDecimalOnKey($(this).val()));
});
$(document).on('keyup', '.number', function() {
    $(this).val(formatNumberOnKey($(this).val()));
});
$(document).on('keyup', '.text-validate', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^ก-ฮ0-9]/g, function(str) { return ''; } ) );
});