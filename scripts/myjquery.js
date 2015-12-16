$(document).ready(function()
{
    var nameGood;
    var phoneNumberGood;
    var emailGood;
    var zipCodeGood;
    var bestContactGood;
    var makeId;
    var modelId;
    var engineId;
    getCarMakes();
    
    $('.full-name').change(function()
    {
        $('#error-name').hide();
        var nameVal = $(this).val();
        var regExCheck = /(.)\1{2,}/;
        console.log(nameVal);
        
        if(!regExCheck.test(nameVal))
        {
            nameGood = nameVal;
            console.log(regExCheck.test(nameVal));
        }
        else
        {
            $('#error-name').show();
            console.log(regExCheck.test(nameVal));
        }
    });
    $('.phone-number').change(function()
    {
        $('#error-phone').hide();
        var phoneVal = $(this).val();
        var regExCheck = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
        console.log(phoneVal);
        
        if(regExCheck.test(phoneVal))
        {
            phoneNumberGood = phoneVal;
            console.log(regExCheck.test(phoneVal));
        }
        else
        {
            $('#error-phone').show();
            console.log(regExCheck.test(phoneVal));
        }
    });
    $('.email-address').change(function()
    {
        $('#error-email').hide();
        var emailVal = $(this).val();
        var regExCheck = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        console.log(emailVal);
        
        if(regExCheck.test(emailVal))
        {
            emailGood = emailVal;
            console.log(regExCheck.test(emailVal));
        }
        else
        {
            $('#error-email').show();
            console.log(regExCheck.test(emailVal));
        }
    });
    $('.zip-code').change(function()
    {
        $('#error-zip').hide();
        var zipVal = $(this).val();
        var regExCheck = /^\d{5}$|^\d{5}-\d{4}$/;
        console.log(zipVal);
        
        if(regExCheck.test(zipVal))
        {
            zipCodeGood = zipVal;
            console.log(regExCheck.test(zipVal));
        }
        else
        {
            $('#error-zip').show();
            console.log(regExCheck.test(zipVal));
        }
    });
    $('.best-contact').change(function()
    {
        $('#error-contact').hide();
        var contactVal = $(this).val();
        var regExCheck = /(.)\1{2,}/;
        console.log(contactVal);
        
        if(!regExCheck.test(contactVal))
        {
            bestContactGood = contactVal;
            console.log(regExCheck.test(contactVal));
        }
        else
        {
            $('#error-contact').show();
            console.log(regExCheck.test(contactVal));
        }
    });
    
    $('#makes').change(function()
    {
        getCarModels();
    });
    $('#models').change(function()
    {
        getCarEngines();
    });
    $('#engines').change(function()
    {
    });
    $('#sales-form').submit(function(event)
    {
        event.preventDefault();
        console.log("Button clicked!!");
        submitData();
    });
    
    function submitData()
    {
        makeId = $('#makes').val();
        console.log(makeId);
        modelId = $('#models').val();
        console.log(modelId);
        engineId = $('#engines').val();
        console.log(engineId);
        $.ajax({
            url: 'scripts/handler.php',
            type: 'POST',
            data: {action : 'submitInfo', fullName : nameGood, 
            phoneNumber : phoneNumberGood, emailAddress : emailGood,
            zipCode : zipCodeGood, bestContact : bestContactGood,
            make : makeId, model : modelId, engine : engineId
            },
            cache: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
                var resultsArray;
                console.log(textStatus);
                console.log(data);
                
                var dealershipList = '';
                if(data.hasOwnProperty('results'))
                {
                    resultsArray = data.results;
                    console.log(resultsArray);
                }
                for(var i = 0; i < resultsArray.length; i++)
                {
                    dealershipList += '<ul>';
                    dealershipList += '<li>' + resultsArray[i].name + '</li>';
                    dealershipList += '<li>' + resultsArray[i].vicinity + '</li>';
                    dealershipList += '</ul>';
                }
                
                $('.success-message').html
                (
                    '<h1> Thank you ' + nameGood + '. </h1>' +
                    '<h2> The following dealerships near ' + zipCodeGood + ' are:</h2>' +
                    dealershipList
                );
                $('#sales-form').hide();
                $('.success-message').show();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               console.log('error');
               console.log(textStatus);
               console.log(errorThrown);
            }
        });
    }
    
    function getCarMakes()
    {
        $.ajax({
           url:'scripts/handler.php',
           type: 'POST',
           data: {action : "makes"},
           cache: false,
           dataType: 'json',
           success: function(data, textStatus, jqXHR)
           {
              $('#makes').append('<option value="null"> Select A Make </option>');
              for(var i = 0; i < data.length; i++)
              {
                  $('#makes').append('<option value=' + data[i][0] + '>' + data[i][1] + '</option>');
              }
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
               console.log('error');
               console.log(textStatus);
               console.log(errorThrown);
           }
        });
    }
    function getCarModels()
    {
        var makes = $('#makes').val();
        $.ajax({
           url:'scripts/handler.php',
           type: 'POST',
           data: {action : "models", make : makes},
           cache: false,
           dataType: 'json',
           success: function(data, textStatus, jqXHR)
           {
               console.log(data);
              $('#models').append('<option value="null"> Select A Model </option>');
              for(var i = 0; i < data.length; i++)
              {
                  $('#models').append('<option value=' + data[i][0] + '>' + data[i][1].toString() + '</option>');
              }
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
               console.log('error');
               console.log(textStatus);
               console.log(errorThrown);
           }
        });
    }
    function getCarEngines()
    {
        var models = $('#models').val();
        $.ajax({
           url:'scripts/handler.php',
           type: 'POST',
           data: {action : "engines", model : models},
           cache: false,
           dataType: 'json',
           success: function(data, textStatus, jqXHR)
           {
               console.log(data);
              $('#engines').append('<option value="null"> Select An Engine </option>');
              for(var i = 0; i < data.length; i++)
              {
                  $('#engines').append('<option value=' + data[i][0] + '>' + data[i][1].toString() + '</option>');
              }
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
               console.log('error');
               console.log(textStatus);
               console.log(errorThrown);
           }
        });
    }
});