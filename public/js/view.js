function scroll() {
    console.log('sc');
    window.scrollTo(0, this.scrollHeight);
}
function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight) + "px";
}


function showSidbar() {
    _('#sidbar').classList.remove('hidden');
    _('#sidbar').classList.remove('-translate-x-96');
}
function hideSidbar() {
    _('#sidbar').classList.add('hidden');
    _('#sidbar').classList.add('-translate-x-96');
}
function selectImg() {
    _("#imgUpload").click();
}

function sendImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            let img = ` <div class="sent col-start-2 col-end-13 p-2 rounded-lg">
                            <div class="flex items-center justify-start flex-row-reverse">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                    A
                                </div>
                                <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                    <img src="${e.target.result}">
                                </div>
                            </div>
                        </div>`;
            _("#chat").insertAdjacentHTML('beforeend', img);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
let mediaRecorder;
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    console.log('getUserMedia supported.');
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then((stream) => {
            mediaRecorder = new MediaRecorder(stream);
            let chunks = [];
            mediaRecorder.addEventListener('dataavailable', (e) => {
                chunks.push(e.data);
            });
            mediaRecorder.addEventListener('stop', (e) => {
                console.log("recorder stopped event");
                const blob = new Blob(chunks, { 'type': 'audio/ogg; codecs=opus' });
                chunks = [];
                const audioURL = window.URL.createObjectURL(blob);

                let audio = ` <div class="sent col-start-2 col-end-13 p-2 rounded-lg">
                            <div class="flex items-center justify-start flex-row-reverse">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                    A
                                </div>
                                <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                    <audio controls>
                                        <source src="${audioURL}" type="audio/ogg">
                                    </audio>
                                </div>
                            </div>
                        </div>`;
                _("#chat").insertAdjacentHTML('beforeend', audio);

            });


        })
        .catch((err) => {
            console.log('The following getUserMedia error occurred: ' + err);
        }
        );
} else {
    console.log('getUserMedia not supported on your browser!');
}


function recordAudio() {
    _("#recording").classList.toggle('hidden');

    if (mediaRecorder.state != "recording") {
        mediaRecorder.start();

        console.log(mediaRecorder.state);
        console.log("recorder started");

    } else {
        mediaRecorder.stop();
        console.log(mediaRecorder.state);
        console.log("recorder stopped");


    };
}
function selectEmoji() {
    _("#emojiSelector").classList.toggle('display');
}

function calling(type) {
    if (type == "vo") {
        _('#voiceCalling').style.display = "block";
    }
    if (type == "ved") {
        _('#vedioCalling').style.display = "block";
    }
}


function _(ele) {
    return document.querySelector(ele);
}