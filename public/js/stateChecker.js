window.onload = () => {

    function stateLinkToggle(){
        const link = document.getElementsByClassName('stateSetLink');
        if(JSON.parse(localStorage.getItem('isStateSet'))){
            link[0].style.display = "none";
        } else {
            link[0].style.display = "inline-flex";
        }
    }

    function checkLinkToggle(){
        const link = document.getElementsByClassName('checkSetLink');
        if(JSON.parse(localStorage.getItem('isCheckSet'))){
            link[0].style.display = "none";
        } else {
            link[0].style.display = "inline-flex";
        }
    }

    const isStateSet = JSON.parse(localStorage.getItem('isStateSet'))
    const isCheckSet = JSON.parse(localStorage.getItem('isCheckSet'))

    const stateSet = document.getElementsByClassName('stateSet');
    const stateSetDash = document.getElementsByClassName('stateSetDash');
    const stateNotSet = document.getElementsByClassName('stateNotSet');

    if(isStateSet && isCheckSet){
        for(const el of stateSet){
            el.style.display = 'inline-flex';
        }
        for(const el of stateSetDash){
            el.style.display = 'block';
        }
        for(const el of stateNotSet){
            el.style.display = "none";
        }
    } else {
        for(const el of stateNotSet){
            el.style.display = 'inline-flex';
        }
        for(const el of stateSetDash){
            el.style.display = 'none';
        }
        for(const el of stateSet){
            el.style.display = "none";
        }
    }

    stateLinkToggle();
    checkLinkToggle();

    const dateChecked = localStorage.getItem('dateChecked');
    const today = new Date().toISOString().split('T')[0];

    if(dateChecked !== today){
        localStorage.setItem('isStateSet', false)
        localStorage.setItem('isCheckSet', false)
    }

    if(!dateChecked || dateChecked !== today || !isStateSet){

        fetch('/check-daily-state')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isStateSet', data.isStateSet)

            if(JSON.parse(localStorage.getItem('isStateSet')) && JSON.parse(localStorage.getItem('isCheckSet'))){
                for(const el of stateSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateSetDash){
                    el.style.display = 'block';
                }
                for(const el of stateNotSet){
                    el.style.display = "none";
                }
            } else {
                for(const el of stateNotSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateSetDash){
                    el.style.display = 'none';
                }
                for(const el of stateSet){
                    el.style.display = "none";
                }
            }

            stateLinkToggle();
            checkLinkToggle();
        })

    }

    if(!dateChecked || dateChecked !== today || !isCheckSet){

        fetch('/check-daily-check')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isCheckSet', data.isCheckSet)

            if(JSON.parse(localStorage.getItem('isStateSet')) && JSON.parse(localStorage.getItem('isCheckSet'))){
                for(const el of stateSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateSetDash){
                    el.style.display = 'block';
                }
                for(const el of stateNotSet){
                    el.style.display = "none";
                }
            } else {
                for(const el of stateNotSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateSetDash){
                    el.style.display = 'none';
                }
                for(const el of stateSet){
                    el.style.display = "none";
                }
            }

            stateLinkToggle();
            checkLinkToggle();
        })

    }

}