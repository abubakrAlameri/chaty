require('./bootstrap');

const form = document.getElementById('input-form');
let currentConversation = document.getElementById('currentConversation');
let chat = document.getElementById('chat');
scrolToButtom();
form.addEventListener('submit',(e)=>{
    e.preventDefault(); 
    let message = e.target.elements['message'];
    if (message.value == ''){
        console.log('false')
        return ;
    }

    const options = {

        method: 'POST',
        url: '/send',
        data: {
            'currentConversation': currentConversation.value, 
            'message': message.value,
        }
    }
    addMessageToScrean(message.value,'sent',window.auth_name);
    message.value = '';
    message.style.height ='2.5rem'
    axios(options)
        .then(response => {
            if(response.status == 200){
               
                chat.lastElementChild.querySelector('.status').innerHTML = "<div>seen</div>";
            }
        })
        .catch(function (error) {
            console.log(error);
        });
})

let x = window.Echo.private(`chat.${currentConversation.value}`)
    .listen('.messages', (e)=>{
        console.log(e);
        if(e.user.id != window.auth_id){
            addMessageToScrean(e.message, 'received' ,e.user.name)
        }
    });


// TODO: fix authentcation issues
// TODO: fix scrolling issues
// TODO: send voice imgae files 
// TODO: make notification 



function addMessageToScrean(message , type ,name){
   let empty = chat.querySelector('#empty');
    if(type == 'sent'){
        let element = `
                        <div class="sent col-start-2 col-end-13 p-2 rounded-lg">
                            <div class="flex items-center justify-start flex-row-reverse">
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                        ${name[0].toUpperCase()}
                                </div>
                                <div class="relative mr-3 break-normal text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                    <div>
                                        ${message}
                                    </div>
                                
                                
                                    <div class="status absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                                        <div id="spinner" class='spinner border-2   rounded-full w-4 h-4'></div>
                                    </div>
                            

                                </div>
                            </div>
                        </div>
            `
        if(empty){
            chat.innerHTML = element;
            return;
        }
        chat.insertAdjacentHTML('beforeend',element );
    }else if(type == 'received'){
        let element = `
                        <div class="receved col-start-1 col-end-12 md:col-end-8 p-2 rounded-lg">
                            <div class="flex flex-row items-center">
                                <div
                                    class="flex items-center justify-center break-normal h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                    ${name[0].toUpperCase()}
                                </div>
                                <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                    <div>
                                            ${message}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
        if (empty) {
            chat.innerHTML = element;
            return;
        }
        chat.insertAdjacentHTML('beforeend', element );
    }

    scrolToButtom()
}

function scrolToButtom(){
    let contianer = document.getElementById('contianer');
    contianer.scrollTo({ top: contianer.scrollHeight, behavior: 'smooth' });
}

function submitForm(e) {
    if (e.which == 13) { 
        document.querySelector('#input-form').submit();
    }
}
