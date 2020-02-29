
// Date Or Category

var date = new Date();

var month=date.getMonth();

 function SelectElement(months,month )
{    
    var element = document.getElementById(months);
    element.value = month;
}

function bydate() {
    var date = document.getElementById("date");
    var cata = document.getElementById("bycata");
    var border1 = document.getElementById("borderchange1");
    var border2 = document.getElementById("borderchange2");
    border1.style.borderBottom ="4px solid #444444 "  ;
    border2.style.borderBottom="";
    if (cata.style.visibility === "visible") 
    {
      date.style.display = "";
      cata.style.visibility="hidden";
      
    }
    else
    {
      date.style.display="";
    }
    
}
function bycata()
{
  var date = document.getElementById("date");
  var cata = document.getElementById("bycata");
  var border2 = document.getElementById("borderchange2");
  var border1 = document.getElementById("borderchange1");
  border2.style.borderBottom ="4px solid #444444  " ;
  border1.style.borderBottom="";
  if(date.style.display === "")
    {
      cata.style.visibility="visible";
      date.style.display="none";
    }
    else{
      cata.style.display="";
    }
}



function passwordcheck() {
  var strength = document.getElementById('strength');
  var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
  var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
  var enoughRegex = new RegExp("(?=.{8,}).*", "g");
  var pwd = document.getElementById("password");
  if (pwd.value.length==0) 
  {
  strength.innerHTML = " Must be 8-20 characters long.";
  } 
  else if (false == enoughRegex.test(pwd.value)) {
  strength.innerHTML = '<span style="color:red">more characters</span>';
  } 
  else if (strongRegex.test(pwd.value)) {
  strength.innerHTML = '<span style="color:green">Strong!</span>';
  }
   else if (mediumRegex.test(pwd.value)) 
   {
  strength.innerHTML = '<span style="color:orange">Medium!</span>';
  } 
  else { 
  strength.innerHTML = '<span style="color:red">Weak!</span>';
  }
  }

  function passwordsMatch(form) {
      password = form.password.value;
      conf_password= form.conf_password.value;
      if(password.length<8)
      {
        strength.innerHTML ='<span style="color:red">Make sure Your Password has at least 8 characters</span>';
        return false;
      }
      if(password != conf_password)
      {
        alert ("\nPassword did not match: Please try again...") 
        return false; 
    
      }
      else {
        alert("Welcome to MoneyManager!")
        return true; 
      }
      
}



    var checker = document.getElementById('gridcheck');
    var sendbtn = document.getElementById('signup');
    // when unchecked or checked, run the function
    checker.onchange = function(){
   if(this.checked){
       sendbtn.disabled = false;
   } 
   else {
       sendbtn.disabled = true;
    }
   
   }



(function () {
  document.forms.register.noValidate = true; // Disable HTML5 validation - using JavaScript instead
  // -------------------------------------------------------------------------
  //  A) ANONYMOUS FUNCTION TRIGGERERD BY THE SUBMIT EVENT
  // -------------------------------------------------------------------------
  $('form').on('submit', function (e) {      // When form is submitted
    var elements = this.elements;            // Collection of form controls
    var valid = {};                          // Custom valid object
    var isValid;                             // isValid: checks form controls
    var isFormValid;                         // isFormValid: checks entire form

    // PERFORM GENERIC CHECKS (calls functions outside the event handler)
    var i;
    for (i = 0, l = elements.length; i < l; i++) {
      // Next line calls validateRequired() validateTypes()
      isValid = validateRequired(elements[i]) && validateTypes(elements[i]); 
      if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(elements[i]);   // Show error messages
      } else {                           // Otherwise
        removeErrorMessage(elements[i]); // Remove error messages
      }                                  // End if statement
      valid[elements[i].id] = isValid;   // Add element to the valid object
    }                                    // End for loop

   

    

    // DID IT PASS / CAN IT SUBMIT THE FORM?
    // Loop through valid object, if there are errors set isFormValid to false
    for (var field in valid) {          // Check properties of the valid object
      if (!valid[field]) {              // If it is not valid
        isFormValid = false;            // Set isFormValid variable to false
        break;                          // Stop the for loop, an error was found
      }                                 // Otherwise
      isFormValid = true;               // The form is valid and OK to submit
    }


    // If the form did not validate, prevent it being submitted
    if (!isFormValid) {                 // If isFormValid is not true
      e.preventDefault();               // Prevent the form being submitted
    }

  });                                   // End of event handler anon function
  //  END: anonymous function triggered by the submit button


  // -------------------------------------------------------------------------
  // B) FUNCTIONS FOR GENERIC CHECKS
  // -------------------------------------------------------------------------

 
  function validateRequired(el) {
    if (isRequired(el)) {                           // Is this element required?
      var valid = !isEmpty(el);                     // Is value not empty (true / false)?
      if (!valid) {                                 // If valid variable holds false
        setErrorMessage(el,  ' * Field is required');  // Set the error message
      }
      return valid;                                 // Return valid variable (true or false)?
    }
    return true;                                    // If not required, all is ok
  }

  // CHECK IF THE ELEMENT IS REQUIRED
  // It is called by validateRequired()
  function isRequired(el) {
   return ((typeof el.required === 'boolean') && el.required) ||
     (typeof el.required === 'string');
  }

  function isEmpty(el) {
    return !el.value || el.value === el.placeholder;
  }

  function validateTypes(el) {
    if (!el.value) return true;                     
    var type = $(el).data('type') || el.getAttribute('type'); 
    if (typeof validateType[type] === 'function') { 
      return validateType[type](el);                
    } else {                                        
      return true;                                  
    }
  }




  // -------------------------------------------------------------------------
  // D) FUNCTIONS TO SET / GET / SHOW / REMOVE ERROR MESSAGES
  // -------------------------------------------------------------------------

  function setErrorMessage(el, message) {
    $(el).data('errorMessage', message);                 // Store error message with element
  }

  function getErrorMessage(el) {
    return $(el).data('errorMessage') || el.title;       // Get error message or title of element
  }

  function showErrorMessage(el) {
    var $el = $(el);                                     // The element with the error
    var errorContainer = $el.siblings('.error.message'); // Any siblings holding an error message

    if (!errorContainer.length) {                         // If no errors exist with the element
       // Create a <span> element to hold the error and add it after the element with the error
       errorContainer = $('<span style="color:red" class="error message"></span>').insertAfter($el);
    }
    errorContainer.text(getErrorMessage(el));             // Add error message
  }

  function removeErrorMessage(el) {
    var errorContainer = $(el).siblings('.error.message'); // Get the sibling of this form control used to hold the error message
    errorContainer.remove();                               // Remove the element that contains the error message
  }



  // -------------------------------------------------------------------------
  // E) OBJECT FOR CHECKING TYPES
  // -------------------------------------------------------------------------

  // Checks whether data is valid, if not set error message
  // Returns true if valid, false if invalid
  var validateType = {
    email: function (el) {                                 // Create email() method
      // Rudimentary regular expression that checks for a single @ in the email
      var valid = /[^@]+@[^@]+/.test(el.value);            // Store result of test in valid
      if (!valid) {                                        // If the value of valid is not true
        setErrorMessage(el, 'Please enter a valid email'); // Set error message
      }
      return valid;                                        // Return the valid variable
    },
   
    
  };

}());  // End of IIFE
