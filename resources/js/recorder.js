import {currentConversation} from './vars';
import {VIEW, HELPERS} from './helpers';
export default function recorders(){
    let mediaRecorder;
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then((stream) => {
                mediaRecorder = new MediaRecorder(stream);
                let chunks = [];
                mediaRecorder.addEventListener('dataavailable', (e) => {
                    chunks.push(e.data);
                });
                mediaRecorder.addEventListener('stop', (e) => {
                    const blob = new Blob(chunks, { 'type': 'audio/ogg' });
                    chunks = [];
                    const audioURL = window.URL.createObjectURL(blob);
                    let audioName = audioURL.split('/');
                    audioName = audioName[audioName.length - 1];

                    let audio = ` 
                            <audio style="width: 200px"    controls>
                                <source src="${audioURL}" type="audio/ogg">
                            </audio>
                        `;
                    VIEW.addMessageToScrean(audio, 'sent', window.auth_name);
                    let f = new FormData();
                    f.append('currentConversation', currentConversation.value);
                    f.append('message', blob, audioName);
                    f.append('type', 'audio');
                    f.append('size', blob.size);


                    HELPERS.send(f);

                });


            })
            .catch((err) => {
                console.log('The following getUserMedia error occurred: ' + err);
            });
    } else {
        console.log('getUserMedia not supported on your browser!');
    }

    document.getElementById('audioButton')
        .addEventListener('click', () => {
            HELPERS.select("#recording").classList.toggle('hidden');
            if (mediaRecorder.state != "recording") {
                mediaRecorder.start();
            } else {
                mediaRecorder.stop();
            };
        });

}
