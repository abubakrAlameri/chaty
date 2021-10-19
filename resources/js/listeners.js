import { VIEW, HELPERS } from './helpers';
import { form, currentConversation,notification, addConv } from './vars';
export default function addMessageListener() {
    const messages = document.querySelectorAll('.message');
    messages.forEach((msg) => {
        msg.addEventListener('submit', (e) => {
            e.preventDefault();
            let loader = msg.querySelector('svg');
            loader.lastElementChild.style.display = 'none';
            let totalLength = loader.firstElementChild.getTotalLength();
            loader.firstElementChild.style.strokeDasharray = totalLength;
            loader.firstElementChild.style.strokeDashoffset = totalLength;
            const form = e.target;
            form.elements['download'].disabled = true;

            axios.get(form.elements['path'].value, {
                responseType: 'blob',
                onDownloadProgress: (progress) => {
                    let uplaodedPresntage = progress.loaded / form.elements['size'].value;
                    loader.firstElementChild.style.strokeDashoffset = totalLength - (uplaodedPresntage * totalLength);
                },
            })
                .then(response => {
                    const url = URL.createObjectURL(response.data)
                    HELPERS.dispalyFile(url, form);
                    form.elements['download'].style.display = 'none';
                })
        })
    });
}
addConv.addEventListener('submit', (e) => {
    e.preventDefault();
    const form = e.target;
    let email = form.elements['email'].value;
    let data = new FormData();
    data.append('email', email);
    form.elements['add-btn'].innerHTML = `<div id='add-chat-spinner'></div>`;
    axios({
        method: 'POST',
        url: '/chats/add',
        data: data,
    })
        .then(response => {
            form.elements['add-btn'].innerHTML = 'add'
            addConv.lastElementChild.classList.add(response.data.color);
            addConv.lastElementChild.textContent = response.data.message;
            const conversations = document.querySelector('#conversations');
            if (response.data.message == 'added successfully') {
                console.log(response.data)
                conversations.insertAdjacentHTML(
                    'beforeend',
                    VIEW.getNewConversationTag(response.data, form.elements['_token'].value)
                )

            }
        });
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
    let message = e.target.elements['message'];

    if (message.value == '') {
        return;
    }

    VIEW.addMessageToScrean(message.value, 'sent', window.auth_name);
    let f = new FormData();
    let size = (new TextEncoder().encode(message.value)).length;
    f.append('currentConversation', currentConversation.value);
    f.append('message', message.value);
    f.append('type', 'text');
    f.append('size', size);

    message.value = '';
    message.style.height = '2.5rem'
    HELPERS.send(f);

})

form.querySelector('#inputText')
    .addEventListener('keypress', (e) => {
        if (e.key == 'Enter') {
            form.dispatchEvent(new Event('submit'));
            e.preventDefault();
        }
    });
form.querySelector('#inputText')
    .addEventListener('input', (e) => {
        e.target.style.height = "5px";
        e.target.style.height = (e.target.scrollHeight) + "px";
        HELPERS.scrolToButtom()
    });


notification.querySelector('#notifi-close')
    .addEventListener('click', (e) => {
        notification.classList.remove('dispaly');

    });

notification.addEventListener('click', (e) => {
    if (notification.classList.contains('dispaly')) notification.submit();
});
document.getElementById('humbargar')
    .addEventListener('click', () => {
        HELPERS.select('#sidbar').classList.remove('hidden');
        HELPERS.select('#sidbar').classList.remove('-translate-x-96');
    });
document.getElementById('close')
    .addEventListener('click', () => {
        HELPERS.select('#sidbar').classList.add('hidden');
        HELPERS.select('#sidbar').classList.add('-translate-x-96');
    });
document.getElementById('fileUpload')
    .addEventListener('change', (input) => {
        if (input.target.files && input.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const size = HELPERS.humenSize(input.target.files[0].size);
                const type = HELPERS.getType(input.target.files[0].type);
                const uploadedFile = e.target.result;
                VIEW.addMessageToScrean(VIEW.getHtmlTags(uploadedFile, type, size, 'sent'), 'sent', window.auth_name);
                let f = new FormData();
                f.append('currentConversation', currentConversation.value);
                f.append('message', input.target.files[0]);
                f.append('type', type);
                f.append('size', input.target.files[0].size);

                HELPERS.send(f);
            };

            reader.readAsDataURL(input.target.files[0]);
        }
    });
document.getElementById('selectFile')
    .addEventListener('click', () => {
        HELPERS.select("#fileUpload").click();
    });
document.getElementById('emojiButton')
    .addEventListener('click', () => {
        HELPERS.select("#emojiSelector").classList.toggle('display');
    });

