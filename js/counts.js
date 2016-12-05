  function showResult(incomme, incommeCosts, social, health){
                if(incomme=="" && incommeCosts=="" && social=="" && health==""){
                    document.getElementById("button").innerHTML="";
                    return;
                } else{
                    document.getElementById("result").innerHTML=" "+incomme+" "
                            +incommeCosts+" "+social+" "+health;
                    /*if(window.XMLHttpRequest){
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    $.post('count.php', {
                        postincomme: incomme,
                        postincommeCosts: incommeCosts,
                        postsocial: social,
                        posthealth: health
                    }, 
                    function(data){
                        $('#result').html(data);
                    }
                    
                    );*/
                    
                    
                }
            }