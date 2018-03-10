
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
    var clg_code=132;
    var cordinator_name = document.forms["reg-form"]["co-ordinator_name"].value;
    var cordinator_email = document.forms["reg-form"]["co-ordinator_email"].value;
    var cordinator_mobile = document.forms["reg-form"]["co-ordinator_mob_no"].value;
    
    var event=document.forms["reg-form"]["event"].value;
    var participants=document.forms["reg-form"]["no_of_participants"].value;
    
    var name = [], email= [], mob_no= [], roll_no=[],branch = [], year =[], course= [];
    name[0] = document.forms["reg-form"]["name[0]"].value;
    email[0] = document.forms["reg-form"]["email[0]"].value;
    roll_no[0] = document.forms["reg-form"]["roll_no[0]"].value;
    mob_no[0] = document.forms["reg-form"]["mob_no[0]"].value;
    branch[0] = document.forms["reg-form"]["branch[0]"].value;
    year[0] = document.forms["reg-form"]["year[0]"].value;
    course[0] = document.forms["reg-form"]["course[0]"].value;

    name[1] = document.forms["reg-form"]["name[1]"].value;
    email[1] = document.forms["reg-form"]["email[1]"].value;
    roll_no[1] = document.forms["reg-form"]["roll_no[1]"].value;
    mob_no[1] = document.forms["reg-form"]["mob_no[1]"].value;
    branch[1] = document.forms["reg-form"]["branch[1]"].value;
    year[1] = document.forms["reg-form"]["year[1]"].value;
    course[1] = document.forms["reg-form"]["course[1]"].value;


    name[2] = document.forms["reg-form"]["name[2]"].value;
    email[2] = document.forms["reg-form"]["email[2]"].value;
    roll_no[2] = document.forms["reg-form"]["roll_no[2]"].value;
    mob_no[2] = document.forms["reg-form"]["mob_no[2]"].value;
    branch[2] = document.forms["reg-form"]["branch[2]"].value;
    year[2] = document.forms["reg-form"]["year[2]"].value;
    course[2] = document.forms["reg-form"]["course[2]"].value;


    name[3] = document.forms["reg-form"]["name[3]"].value;
    email[3] = document.forms["reg-form"]["email[3]"].value;
    roll_no[3] = document.forms["reg-form"]["roll_no[3]"].value;
    mob_no[3] = document.forms["reg-form"]["mob_no[3]"].value;
    branch[3] = document.forms["reg-form"]["branch[3]"].value;
    year[3] = document.forms["reg-form"]["year[3]"].value;
    course[3] = document.forms["reg-form"]["course[3]"].value;
    var event_name=document.getElementById("event_name").value;
    event_name = parseInt(event_name);
    if(participants == "null" || event_name != "0"){
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER TEAM SIZE";
        return false;
    }

    if(clg_name == ""){
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER COLLEGE NAME";
        return false;
    }
    else if(clg_code == "" ){
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER COLLEGE CODE";
        return false;
    }
    else if(cordinator_name == ""){
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER COLLEGE CORDINATOR NAME";
        return false;
    }
    else if(event=="")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE CHOOSE A EVENT";
        return false;
    }
    else if(cordinator_email == "")
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORDINATOR'S EMAIL";
        return false;
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(cordinator_email)))
    {
        document.getElementById("message").className="";
        document.getElementById("message").className="error";
        document.getElementById("message").innerHTML="PLEASE ENTER CORRECT CORDINATOR EMAIL";
        return false;
    }
    else if(cordinator_mobile.length != 10 || isNaN(cordinator_mobile) )
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE CORRECT CORDINATOR MOBILE NUMBER";
            return false;
        }

    
    for(var i = 0; i< participants; i++){
        if (name[i] == "") 
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER YOUR NAME";
            return false;
        }
        else if(email[i] == "")
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER YOUR EMAIL";
            return false;
        }
        else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email[i])))
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER CORRECT EMAIL";
            return false;
        }
        else if(isNaN(roll_no[i]) || roll_no[i].length < 1)
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER CORRECT ROLL NUMBER";
            return false;
        }
        else if(mob_no[i].length != 10 || isNaN(mob_no[i]) )
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE CORRECT MOBILE NUMBER";
            return false;
        }
        else if(branch[i] == "")
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER YOUR BRANCH";
            return false;
        }
        else if(year[i] == "")
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER YOUR YEAR";
            return false;
        }
        else if(course[i] == "")
        {
            document.getElementById("message").className="";
            document.getElementById("message").className="error";
            document.getElementById("message").innerHTML="PLEASE ENTER YOUR COURSE";
            return false;
        }    
    }
}

function disable()
{
    var select=document.getElementById("select").value;
    var form2=document.getElementById("form2");
    var form1=document.getElementById("form1");
    var form3=document.getElementById("form3");
    var form4=document.getElementById("form4");
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
function hide_form()
{
    var event=document.getElementById("event_name").value;
    var selector=document.getElementById("select");
    if(event==4||event==6 || event== 10)
    {
        form2.className="";
        form2.className="hidden";
        form3.className="";
        form3.className="hidden";
        form4.className="";
        form4.className="hidden";
        form1.className="";
        form1.className="col-sm-12";
        selector.className="hidden";
        document.getElementById("option2").className="hidden";
        document.getElementById("option3").className="hidden";
        document.getElementById("option4").className="hidden";
    }
    else if(event==0 ||event==1 || event==2 || event==3 ||event==9)
    {
        form2.className="";
        form2.className="col-sm-12";
        form1.className="";
        form1.className="col-sm-12";
        selector.className="select";
        form3.className="";
        form3.className="hidden";
        form4.className="";
        form4.className="hidden";
        document.getElementById("option2").className="";
        document.getElementById("option3").className="hidden";
        document.getElementById("option4").className="hidden";
    }
    else if(event==5)
    {
        form2.className="";
        form2.className="col-sm-12";
        form1.className="";
        form1.className="col-sm-12";
        selector.className="select";
        form3.className="";
        form3.className="col-sm-12";
        form4.className="";
        form4.className="hidden";
        document.getElementById("option2").className="";
        document.getElementById("option3").className="";
        document.getElementById("option4").className="hidden";
    }
    else
    {
        form2.className="";
        form2.className="col-sm-12";
        form1.className="";
        form1.className="col-sm-12";
        selector.className="select";
        form3.className="";
        form3.className="col-sm-12";
        form4.className="";
        form4.className="col-sm-12";
        document.getElementById("option2").className="";
        document.getElementById("option3").className="";
        document.getElementById("option4").className="";

    }

}