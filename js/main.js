
particleground(document.getElementById('skill'), {
dotColor: 'rgba(255,255,255,0.5)',
lineColor: 'rgba(255,255,255,0.1)',
density:50000,
maxSpeedX:5,
maxSpeedY:3
});

$(window).on('load',(function() {
$("#overlayer").delay(2000).fadeOut("slow");
}));

var waves = new SineWaves({
el: document.getElementById('waves'),

speed: 3,

width: function() {
    return $(window).width();
},

height: function() {
    return $(window).height();
},

ease: 'SineInOut',

wavesWidth: '50%',

waves: [
    {
    
    timeModifier: 4,
    lineWidth: 1,
    amplitude: -100,
    waveLength: 600
    },
    {
    type: 'SineWave',
    segmentLength: 1,
    },
    {
    timeModifier: 2,
    lineWidth: 2,
    amplitude: -150,
    wavelength: 50
    },
    {
    timeModifier: 1,
    lineWidth: 1,
    amplitude: -200,
    wavelength: 150
    },
    {
    timeModifier: 0.5,
    lineWidth: 1,
    amplitude: -120,
    wavelength: 100
    },
    {
    timeModifier: 0.25,
    lineWidth: 2,
    amplitude: -75,
    wavelength: 400
    }
],

    // Called on window resize
    resizeEvent: function() {
        
        var gradient = this.ctx.createLinearGradient(0, 0, this.width, 0);
        gradient.addColorStop(0,"rgba(230, 255,255, 0.0)");
        gradient.addColorStop(0.5,"rgba(255, 255, 255, 0.05)");
        gradient.addColorStop(1,"rgba(255, 255, 255, 0.0)");
        
        var index = -1;
        var length = this.waves.length;

        for(index=0;index< length;index++){
        this.waves[index].strokeStyle = gradient;
        }
        
        // Clean Up

    }
});

function validateForm() 
{   
    var clg_name=document.forms["reg-form"]["clg_name"].value;
    var event=document.forms["reg-form"]["event"].value;
    var name_1 = document.forms["reg-form"]["name_1"].value;
    var email_1=document.forms["reg-form"]["email_1"].value;
    var roll_no_1=document.forms["reg-form"]["roll_no_1"].value;
    var mob_no_1=document.forms["reg-form"]["mob_no_1"].value;
    var name_2 = document.forms["reg-form"]["name_2"].value;
    var email_2=document.forms["reg-form"]["email_2"].value;
    var roll_no_2=document.forms["reg-form"]["roll_no_2"].value;
    var mob_no_2=document.forms["reg-form"]["mob_no_2"].value;
    var participants=document.forms["reg-form"]["no_of_participants"].value;
    if(participants==2)
    {
    if(clg_name== "")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER COLLEGE NAME";
        return false;
    }
    else if(event=="")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE CHOOSE A EVENT";
        return false;
    }
    else if (name_1 == "" || name_2 == "") 
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER YOUR NAME";
        return false;
    }
    else if(email_1== ""||email_2=="")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER YOUR EMAIL";
        return false;
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_1))||!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_2)))
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORRECT EMAIL";
        return false;
    }
    else if(isNaN(roll_no_1) || isNaN(roll_no_2) || roll_no_1.length < 1 || roll_no_2.length < 1)
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORRECT ROLL NUMBER";
        return false;
    }
    else if(mob_no_1.length != 10 || isNaN(mob_no_2) || mob_no_2.length != 10 || isNaN(mob_no_2))
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE CORRECT MOBILE NUMBER";
        return false;
    }
}
else
{
    if(clg_name== "")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER COLLEGE NAME";
        return false;
    }
    else if(event=="")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE CHOOSE A EVENT";
        return false;
    }
    else if (name_1 == "") 
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER YOUR NAME";
        return false;
    }
    else if(email_1== "")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER YOUR EMAIL";
        return false;
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_1)))
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORRECT EMAIL";
        return false;
    }
    else if(isNaN(roll_no_1) || roll_no_1.length < 1)
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORRECT ROLL NUMBER";
        return false;
    }
    else if(mob_no_1.length != 10 || isNaN(mob_no_1))
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE CORRECT MOBILE NUMBER";
        return false;
    }
}
}
function disable()
{
    var select=document.getElementById("select").value;
    var form2=document.getElementById("form2");
    var form1=document.getElementById("form1");
    
    if (select==1) 
    {
        form2.className="";
        form2.className="hidden";
        form1.className="";
        form1.className="col-sm-12";

    }
    else if(select==2)
    {
        form2.className="";
        form2.className="col-sm-6";
        form1.className="";
        form1.className="col-sm-6";

    }
}