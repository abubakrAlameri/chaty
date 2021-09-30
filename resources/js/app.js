require('./bootstrap');

let is_read ;

const form = document.getElementById('input-form');

const currentConversation = document.getElementById('currentConversation');
const chat = document.getElementById('chat');
const notification = document.getElementById('notification');

scrolToButtom();


//events listeners
const addConv = document.getElementById('add-conv');

addConv.addEventListener('submit', (e) => {
    e.preventDefault();
    let email = e.target.elements['email'].value;
    let url = e.target.getAttribute('action');
    let data = new FormData();
    data.append('email', email);
    e.target.elements['add-btn'].innerHTML = spinner(`left: 1rem ; bottom: 0`);
    axios({
        method: 'POST',
        url: url,
        data: data,
    })
    .then(response => {
        e.target.elements['add-btn'].innerHTML = 'add'
        addConv.lastElementChild.classList.add(response.data.color);
        addConv.lastElementChild.textContent = response.data.message;
        if (response.data.message == 'added successfully'){

        }
    });
});
form.addEventListener('submit',(e)=>{
    e.preventDefault(); 
    let message = e.target.elements['message'];
    
    if (message.value == ''){
        return ;
    }    

    addMessageToScrean(message.value,'sent',window.auth_name);
    let options = {
        method: 'POST',
        url: '/send',
        data: {
            'currentConversation': currentConversation.value,
            'message': message.value,
        }
    };
    message.value = '';
    message.style.height ='2.5rem'
    axios(options)    
        .then(response => {
            if(response.status == 200){
                let status ;
            
                if(is_read){
                    status = doubleCheck();
                }    
                else{
                    status = check();
                }    
                    chat.lastElementChild.querySelector('.status').innerHTML = status;
            }        
        })    
        .catch(function (error) {
            console.log(error);
        });    
})    
notification.querySelector('#notifi-close').addEventListener('click' , (e)=>{
    notification.classList.remove('dispaly');

});    

notification.addEventListener('click' , (e)=>{
    console.log(notification.classList.contains('dispaly'));
    if(notification.classList.contains('dispaly')) notification.submit();
});    




// real time listeners
window.Echo.private(`chat.${currentConversation.value}`)
    .listen('.messages', (msg) => {
        console.log(msg);
        is_read = msg.is_read;

        if (msg.user.id != window.auth_id) {
            addMessageToScrean(msg.message, 'received', msg.user.name)
        }
    });
window.Echo.private(`message-read.${currentConversation.value}`)
    .listen('.read-message', (read) => {
        if (read.currentConversation == currentConversation.value) {

            let unreadMessages = chat.querySelectorAll('.status > .unread');
            unreadMessages.forEach(message => {
                message.parentNode.innerHTML = `<div class='read'><svg viewBox="0 0 30 30" width="20" fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 6.278l-11.16 12.722-6.84-6 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.278zm-22.681 5.232l6.835 6.01-1.314 1.48-6.84-6 1.319-1.49zm9.278.218l5.921-6.728 1.482 1.285-5.921 6.756-1.482-1.313z"/></svg></div>`;
            });

        }

    });
window.Echo.private(`App.Models.User.${window.auth_id}`)
    .notification((notifi) => {
        let user = JSON.parse(notifi.user);
        notification.querySelector(`input[name='conv_id']`).value = notifi.conversation;
        notification.querySelector(`input[name='name']`).value = user.name;
        notification.querySelector(`#name`).textContent = user.name;
        notification.querySelector(`#message`).textContent = notifi.message;
        const sound = new Audio('/audio/notification.mp3')
        sound.play();
        notification.classList.add('dispaly');
        increasUnreadMessages(notifi.conversation);

        setTimeout(function () {
            notification.classList.remove('dispaly');
        }, 5000);
    });


//functions

function increasUnreadMessages(conversation){
    let conv = document.getElementById(`conv-${conversation}`);
    let counter = conv.querySelector('#unread-count');
    counter.classList.remove('hidden');
    console.log(counter.textContent.trim() + 1);
    counter.textContent = 1 + +counter.textContent.trim();
}
function addMessageToScrean(message, type, name) {
    let empty = chat.querySelector('#empty');
    if (type == 'sent') {
        let element = sentMessage(name[0].toUpperCase(), message);
        if (empty) {
            chat.innerHTML = element;
            return;
        }
        chat.insertAdjacentHTML('beforeend', element);
    } else if (type == 'received') {
        let element = receivedMessage(name[0].toUpperCase(), message);
        if (empty) {
            chat.innerHTML = element;
            return;
        }
        chat.insertAdjacentHTML('beforeend', element);
    }

    scrolToButtom()
}

function scrolToButtom() {
    if (form) {
        let contianer = document.getElementById('contianer');
        form.querySelector('#inputText').focus();
        contianer.scrollTo({ top: contianer.scrollHeight, behavior: 'smooth' });
    }
}

function submitForm(e) {
    if (e.which == 13) {
        document.querySelector('#input-form').submit();
    }
}

function spinner(style = '') {
    return `<div id="spinner" style="${style}" class='spinner border-2 rounded-full w-3 h-3'></div>`;
}

function doubleCheck() {
    return `<div class='read'><svg viewBox="0 0 30 30" width="20" fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 6.278l-11.16 12.722-6.84-6 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.278zm-22.681 5.232l6.835 6.01-1.314 1.48-6.84-6 1.319-1.49zm9.278.218l5.921-6.728 1.482 1.285-5.921 6.756-1.482-1.313z"/></svg></div>`;
}

function check() {
    return `<div class='unread'><svg viewBox="0 0 30 30" width="20" fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z"/></svg></div>`;
}
function sentMessage(name, message) {
    return `<div class="sent col-start-2 col-end-13 p-2 rounded-lg">
                <div class="flex items-center justify-start flex-row-reverse">
                    <div
                        class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                            ${name}
                    </div>
                    <div class="relative mr-3 break-all text-sm bg-indigo-100 py-4 px-4 shadow rounded-xl">
                        <div>
                            ${message}
                        </div>
                    
                    
                        <div class="status absolute text-xs bottom-0 right-0 -mb-1 mr-2 text-gray-500">
                            ${spinner()}
                        </div>
                

                    </div>
                </div>
            </div>`;
}

function receivedMessage(name, message) {
    return ` <div class="receved col-start-1 col-end-12 md:col-end-8 p-2 rounded-lg">
                <div class="flex flex-row items-center">
                    <div
                        class="flex items-center justify-center break-normal h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                        ${name}
                    </div>
                    <div class="relative ml-3 break-all text-sm bg-white py-4 px-4 shadow rounded-xl">
                        <div>
                                ${message}
                        </div>
                    </div>
                </div>
            </div>
        `;
}