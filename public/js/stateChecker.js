window.onload = () => {

    function stateLinkToggle(){
        const link = document.getElementsByClassName('stateSetLink');
        if(JSON.parse(localStorage.getItem('isStateSet'))){
            if(link[0]){link[0].style.display = "none";}
        } else {
            if(link[0]){link[0].style.display = "inline-flex";}
        }
    }

    function checkLinkToggle(){
        const link = document.getElementsByClassName('checkSetLink');
        if(JSON.parse(localStorage.getItem('isCheckSet'))){
            if(link[0]){link[0].style.display = "none";}
        } else {
            if(link[0]){link[0].style.display = "inline-flex";}
        }
    }

    function slipLinkToggle(){
        const link = document.getElementsByClassName('slipSetLink');
        if(JSON.parse(localStorage.getItem('isSlipSet'))){
            if(link[0]){link[0].style.display = "none";}
        } else {
            if(link[0]){link[0].style.display = "inline-flex";}
        }
    }

    const isStateSet = JSON.parse(localStorage.getItem('isStateSet'))
    const isCheckSet = JSON.parse(localStorage.getItem('isCheckSet'))
    const isSlipSet = JSON.parse(localStorage.getItem('isSlipSet'))

    const stateSet = document.getElementsByClassName('stateSet');
    const stateSetDash = document.getElementsByClassName('stateSetDash');
    const stateNotSet = document.getElementsByClassName('stateNotSet');

    if(isStateSet && isCheckSet && isSlipSet){
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
    slipLinkToggle();

    const dateChecked = localStorage.getItem('dateChecked');
    const today = new Date().toISOString().split('T')[0];

    if(dateChecked !== today){
        localStorage.setItem('isStateSet', false)
        localStorage.setItem('isCheckSet', false)
        localStorage.setItem('isSlipSet', false)
    }

    if(!dateChecked || dateChecked !== today || !isStateSet){

        fetch('/check-daily-state')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isStateSet', data.isStateSet)

            if(JSON.parse(localStorage.getItem('isStateSet')) && JSON.parse(localStorage.getItem('isCheckSet')) && JSON.parse(localStorage.getItem('isSlipSet'))){
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
            slipLinkToggle();
        })

    }

    if(!dateChecked || dateChecked !== today || !isCheckSet){

        fetch('/check-daily-check')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isCheckSet', data.isCheckSet)

            if(JSON.parse(localStorage.getItem('isStateSet')) && JSON.parse(localStorage.getItem('isCheckSet')) && JSON.parse(localStorage.getItem('isSlipSet'))){
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
            slipLinkToggle();
        })

    }

    if(!dateChecked || dateChecked !== today || !isCheckSet){

        fetch('/check-daily-slip')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isSlipSet', data.isSlipSet)

            if(JSON.parse(localStorage.getItem('isStateSet')) && JSON.parse(localStorage.getItem('isCheckSet')) && JSON.parse(localStorage.getItem('isSlipSet'))){
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
            slipLinkToggle();
        })

    }

}