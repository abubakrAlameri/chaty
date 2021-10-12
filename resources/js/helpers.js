import { form, chat} from './vars';

const VIEW = {
    spinner(messageCounter) {
        return `<div id="spinner${messageCounter}" style="position: relative;left: 0rem;bottom: 0.30rem;" class='w-3 h-3'>
                <svg svg viewBox = "0 0 12 12"width = "12" height = "12" >
                    <circle class="progress-circle" cx="6" cy="6" stroke="#4338CA" r="4" fill="transparent" stroke-width="2" />
                </svg>
            </div>`;
    },
    getHtmlTags(message, type, size, directionOfMessage){
        if (type == 'text') {
            return message;
        }


        let msg = ``;
        if (directionOfMessage == 'received') {
            msg = `<form class="message relative" >
                                    <input type="hidden" name='msg_id' value="">
                                    <input type="hidden" name="type" value="${type}">
                                    <input type="hidden" name="size" value="${size}">
                                    <button name="download" class ="absolute flex flex-col justify-center items-center w-full h-full bg-white opacity-100 z-10">
                                        <svg class ="w-10 h-10" viewBox = "0 0 100 100"  >
                                        <circle style="transition: 0.5s linear" class ="" cx="50" cy="50" stroke="#4338CA" r="40" fill="transparent" stroke="#4338CA" stroke-width="4" />
                                        <path stroke="#4338CA" stroke-width="3" transform="translate(40,40)" d="M11 21.883l-6.235-7.527-.765.644 7.521 9 7.479-9-.764-.645-6.236 7.529v-21.884h-1v21.883z"/>
                                        </svg>
                                        <p class ="text-xs text-gray-500">${type}</p>
            
                                        </button>
                                    <input type ="hidden" name="path" value="${message}">
                            `;
            message = '#';
        }

        if (type == 'image') {
            msg += `<img width="200" height="200" src="${message}">`;
        }

        if (type == 'audio') {
            msg += ` <audio style="width: 200px"  controls>
                            <source src="${message}" type="audio/ogg">
                        </audio>`;
        }

        if (type == 'video') {
            msg += `<video width="200" height="200" poster preload controls>
                            <source src="${message}" >
                        </video>`
        }
        if (type == 'document') {

            msg += ` <a href="${message}" download="download" class="flex items-center justify-center w-36 rounded border-indigo-300" style="border-width: 1px">
                            <div class="w-1/4  p-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#4338CA"><path d="M11.362 2c4.156 0 2.638 6 2.638 6s6-1.65 6 2.457v11.543h-16v-20h7.362zm.827-2h-10.189v24h20v-14.386c0-2.391-6.648-9.614-9.811-9.614z"/></svg>
                            </div>
                            <div class="w-2/3 text-gray-400 border-l-2 border-indigo-300 pl-4  p-1 " style="border-left-width: 1px">
                                <p class="text-sm">FILE</p>
                                <p class="text-xs">` + size + `</p>
                            </div>
                        </a>`;
        }
        if (directionOfMessage == 'received') {
            msg += `</form>`;
        }
        return msg;
    }, 
    doubleCheck() {
        return `<div class='read'><svg viewBox="0 0 30 30" width="20" fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 6.278l-11.16 12.722-6.84-6 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.278zm-22.681 5.232l6.835 6.01-1.314 1.48-6.84-6 1.319-1.49zm9.278.218l5.921-6.728 1.482 1.285-5.921 6.756-1.482-1.313z"/></svg></div>`;
    },
    check() {
        return `<div class='unread'><svg viewBox="0 0 30 30" width="20" fill="#4338CA"  height="20" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z"/></svg></div>`;
    },
    receivedMessage(name, message) {
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
    },
    sentMessage(name, message) {
        window.messageCounter++;

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
                            ${this.spinner(window.messageCounter)}
                        </div>
                

                    </div>
                </div>
            </div>`;
    },
    addMessageToScrean(message, directionOfMessage, name) {
        // const chat = document.getElementById('chat');

        let empty = chat.querySelector('#empty');
        if (directionOfMessage == 'sent') {
            let element = this.sentMessage(name[0].toUpperCase(), message);
            if (empty) {
                chat.innerHTML = element;
                return;
            }
            chat.insertAdjacentHTML('beforeend', element);
        } else if (directionOfMessage == 'received') {
            let element = this.receivedMessage(name[0].toUpperCase(), message);
            if (empty) {
                chat.innerHTML = element;
                return;
            }

            chat.insertAdjacentHTML('beforeend', element);
        }

        HELPERS.scrolToButtom()
    },
    getNewConversationTag({ user_id, conv_id, name, is_active, last_seen }, token){
        return ` <form action="${window.location.href.slice(0, window.location.href.length - 1)}" method="post" class="conversation w-full">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="hidden" name="conv_id" value="${conv_id}">
                    <input type="hidden" name="name" value="${name}">
                    <button id="conv-${conv_id}"
                        class="flex flex-row
                                items-center w-full
                                hover:bg-gray-100
                                rounded-xl p-2">
                        <div class="flex relative items-center justify-center h-8 w-8 bg-gray-200 rounded-full font-bold">
                            ${name[0].toUpperCase()}
                                <span id="unread-count" 
                                class="
                                    hidden
                                    absolute w-4 h-4
                                    -bottom-1 left-4
                                    rounded-full
                                    bg-red-600
                                    text-white"
                                    style="font-size:10px; padding: 1px 2px">
                                    0
                                </span>
                        </div>

                        <div class="ml-2 text-sm font-semibold capitalize">${name}</div>
                        ${is_active
                ? `<div class="flex items-center
                                    justify-center ml-auto
                                    text-xs text-white
                                    bg-green-500 h-2 w-2 rounded-full leading-none">

                            </div>`
                : `<span class=" ml-auto  text-indigo-700 font-semibold" style="font-size: 10px">${last_seen}</span>`}
                    </button>
                </form>`;
    }

};

const HELPERS = {
    send(data) {
        // const chat = document.getElementById('chat');
        let options = {
            method: 'POST',
            url: '/send',
            data: data,
            onUploadProgress: (progressEvent) => {
                const spinner = this.select(`#spinner${window.messageCounter} > svg > circle`);
                let uplaodedPresntage = progressEvent.loaded / data.get('size');
                const totalLength = spinner.getTotalLength();
                spinner.style.strokeDashoffset = totalLength - (uplaodedPresntage * totalLength);
            },
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        };
        axios(options)
            .then(response => {
                if (response.status == 200) {
                    let status;

                    if (window.is_read) {
                        status = VIEW.doubleCheck();
                    }
                    else {
                        status = VIEW.check();
                    }
                    chat.lastElementChild.querySelector('.status').innerHTML = status;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    dispalyFile(url, form) {
        const type = form.elements['type'].value;
        let selector = '';
        console.log(type)
        if (type == 'document') {
            form.querySelector('a').href = url;
            return;
        }

        if (type == 'video' || type == 'audio') {
            selector = `${type} `;
        }
        else if (type == 'image') {
            selector = 'img';
        }

        form.querySelector(selector).setAttribute('src', url);
    },
    humenSize(size) {
        let exp = Math.log(size) / Math.log(1024) | 0;
        let result = (size / Math.pow(1024, exp)).toFixed(2);
        return result + (exp == 0 ? 'B' : 'KMGTPEZY'[exp - 1] + 'B');

    },
    getType(type) {
        const realType = type.substr(0, type.indexOf('/'))

        if (realType == 'application' || realType == 'text') {
            return 'document';
        }
        return realType;
    },
    increasUnreadMessages(conversation) {
        const conv = document.getElementById(`conv-${conversation}`);
        const counter = conv.querySelector('#unread-count');
        counter.classList.remove('hidden');
        counter.textContent = 1 + +counter.textContent.trim();
    },
    scrolToButtom() {
        // const form = document.getElementById('input-form');

        if (form) {
            let contianer = document.getElementById('contianer');
            form.querySelector('#inputText').focus();
            contianer.scrollTo({ top: contianer.scrollHeight, behavior: 'smooth' });
        }
    },
    select(ele) {
        return document.querySelector(ele);
    },
    calling(type) {
        if (type == "vo") {
            HELPERS.select('#voiceCalling').style.display = "block";
        }
        if (type == "ved") {
            HELPERS.select('#vedioCalling').style.display = "block";
        }
    },
};

export {VIEW , HELPERS};