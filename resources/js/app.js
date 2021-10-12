require('./bootstrap');
import addMessageListener from './listeners';
import { VIEW , HELPERS } from './helpers';
import { currentConversation, chat, notification} from './vars';
import recorder from './recorder';

window.is_read ;
window.messageCounter = 0;



recorder();
addMessageListener()
HELPERS.scrolToButtom();

window.Echo.private(`chat.${currentConversation.value}`)
    .listen('.messages', (msg) => {
        
        window.is_read = msg.is_read;
        if (msg.user.id != window.auth_id) {
            VIEW.addMessageToScrean(
                VIEW.getHtmlTags(msg.message, msg.msgType, HELPERS.humenSize(msg.size),'received'), 
                'received', msg.user.name
            );
            addMessageListener();
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
        let messageContent = '';
        if (notifi.msgType == 'New Conversation'){
            messageContent = notifi.msgType;
        }
        else if (notifi.msgType != 'text'){
            messageContent = 'FILE';
        }
        else{
            messageContent = notifi.message;


        }
        notification.querySelector(`#message`).textContent = messageContent;
        const sound = new Audio('/audio/notification.mp3')
        sound.play();
        notification.classList.add('dispaly');
        if (notifi.msgType != 'New Conversation') {
            HELPERS.increasUnreadMessages(notifi.conversation);
        }

        setTimeout(function () {
            notification.classList.remove('dispaly');
        }, 5000);
    });











