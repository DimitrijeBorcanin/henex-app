window.onload = () => {

    const isStateSet = JSON.parse(localStorage.getItem('isStateSet'))

    const stateSet = document.getElementsByClassName('stateSet');
    const stateSetDash = document.getElementsByClassName('stateSetDash');
    const stateNotSet = document.getElementsByClassName('stateNotSet');

    if(isStateSet){
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

    const dateChecked = localStorage.getItem('dateChecked');
    const today = new Date().toISOString().split('T')[0];

    if(!dateChecked || dateChecked !== today || !isStateSet){

        fetch('/check-daily-state')
        .then(response => response.json())
        .then(data => {
            localStorage.setItem('dateChecked', today);
            localStorage.setItem('isStateSet', data.isStateSet)

            if(JSON.parse(localStorage.getItem('isStateSet'))){
                for(const el of stateSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateNotSet){
                    el.style.display = "none";
                }
            } else {
                for(const el of stateNotSet){
                    el.style.display = 'inline-flex';
                }
                for(const el of stateSet){
                    el.style.display = "none";
                }
            }
        })

    }

}