        function showResult(){
                
                var incomme = $('#incomme').val();
                var incommeCosts = $('#incommeCosts').val();
                var social = $('#social').val();
                var health = $('#health').val();
                
                //document.getElementById('#result').innerHTML = incomme;
                
                
                    
                    if(window.XMLHttpRequest){
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    $.post('getDatas.php', {
                        postincomme: incomme,
                        postincommeCosts: incommeCosts,
                        postsocial: social,
                        posthealth: health
                    }, 
                    function(data){
                        $('#result').html(data);
                    }
                    
                    );

            }