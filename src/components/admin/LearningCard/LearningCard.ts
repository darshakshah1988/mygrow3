import { Component, Prop, Vue, Watch, Inject } from 'vue-property-decorator'
import { State, Getter, Mutation } from 'vuex-class'

import * as vue2Dropzone from 'vue2-dropzone'
import * as moment from 'moment'
import './LearningCard.scss'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { ProgressBar } from '../../shared/ProgressBar'
import { QuizBuilder } from '../QuizBuilder'
import { AudioPlayer } from '../../shared/AudioPlayer'
import { Quiz } from '../../student/Quiz'
import store from '../../../store'
import { BASE_URL } from '../../../constants'
import { Action } from '../../../interfaces'


@Component({
    template: require('./LearningCard.html'),
    name: 'LearningCard',
    components: {
        ProgressBar,
        QuizBuilder,
        Quiz,
        AudioPlayer,
        vueDropzone: vue2Dropzone,
        DatePicker
    }
})
export class LearningCard extends Vue {
    @Inject() toggleModal

    quizVisible = false
    taskVisible = false

    @Getter currentCard
    @State route
    @State courses
    @State admin
    @State subscription
    @State storageUsage

    name = ''
    ready = false
    content = ''
    evidence = ''
    quiz = []
    audioUploadPercent = 0
    audioIsUploading = false
    videoUploadPercent = 0
    videoIsUploading = false
    youtubeUploadPercent = 0
    youtubeIsUploading = false
    cardType = ''
    time = ''
    timeSlots = []
    date = null
    location= ''
    attendees = [{name:"Test",role:"Facilitator"},{name:"Test",role:"Timer"}]
    agendaTopic = ''
    agendaActions = []
    roles=["Facilitator","Timer","Attendee"]

    sharedConfig = {
        key: 'OD2G2D4I4D3A13hC7D6C5D4D2E3J4C6A6C6cgsmtJ2C8eheE5kC-8==',
        iconsTemplate: 'font_awesome_5',
        pastePlain: true,
        fontSizeSelection: true,
        fontSize: [
            '20',
            '18',
            '16'
        ],
        charCounterCount: false,
        quickInsertTags: [''],
        // WARNING! These fields are not even named correctly. See from docs they should be:
        // • imageUploadURL is the URL where the upload request is being made.
        // • imageUploadMethod is the HTTP request type.
        // fileUpload: true,
        // fileUploadMethod: 'PUT',
        // fileUploadURL: '/api/card/2',
        toolbarButtons: [
            'undo',
            'redo',
            '|',
            'fontSize',
            'bold',
            'italic',
            'underline',
            'outdent',
            'indent',
            'clearFormatting',
            '|',
            'insertImage'
        ],
        imageInsertButtons: [
            'imageBack',
            '|',
            'imageUpload',
            'imageByURL'
        ]
    }

    contentConfig = Object.assign({}, this.sharedConfig, {
        placeholderText: 'Start writing',
        height: 400,
        events: {
            'froalaEditor.image.beforeUpload': function (e, editor, files) {
                if (files.length) {
                    // Create a File Reader.
                    const reader = new FileReader()

                    // Set the reader to insert images when they are loaded.
                    reader.onload = function (e) {
                        const target = <any>e.target
                        const result = target.result
                        editor.image.insert(result, null, null, editor.image.get())
                        console.log('yay')
                    }

                    // Read image as base64.
                    reader.readAsDataURL(files[0])
                }

                editor.popups.hideAll()

                // Stop default upload chain.
                return false
            },
            'froalaEditor.contentChanged': (e, editor) => {
                this.content = editor.html.get()
                setTimeout(() => {
                    this.save()
                }, 500)
            }
        }
    })

    evidenceConfig = Object.assign({}, this.sharedConfig, {
        placeholderText: 'Ask your users to perform a practical task related to the content in this card',
        height: 150,
        events: {
            'froalaEditor.image.beforeUpload': function (e, editor, files) {
                if (files.length) {
                    // Create a File Reader.
                    const reader = new FileReader()

                    // Set the reader to insert images when they are loaded.
                    reader.onload = function (e) {
                        const target = <any>e.target
                        const result = target.result
                        editor.image.insert(result, null, null, editor.image.get())
                        console.log('yay')
                    }

                    // Read image as base64.
                    reader.readAsDataURL(files[0])
                }

                editor.popups.hideAll()

                // Stop default upload chain.
                return false
            },
            'froalaEditor.contentChanged': (e, editor) => {
                this.evidence = editor.html.get()
                setTimeout(() => {
                    this.save()
                }, 500)
            }
        }
    })

    $refs: {
        audio: HTMLAudioElement
        AudioDropzone: any
        video: HTMLVideoElement
        youtube: HTMLIFrameElement
        mobileVideo: HTMLVideoElement
        mobileYoutube: HTMLIFrameElement
        VideoDropzone: any
        YoutubeDropzone: any
        name: HTMLInputElement
        player: AudioPlayer
    }

    @Watch('currentCard', { deep: true })
    watchCurrentCard(newVal, oldVal) {
        console.log(newVal);
        
        if (newVal && newVal.content) {
            this.content = newVal.content
        }
        if (newVal && newVal.evidence_task) {
            this.evidence = newVal.evidence_task
        }
        if (newVal && newVal.quiz) {
            this.quiz = JSON.parse(newVal.quiz)
        }
        if (newVal && newVal.name) {
            this.name = newVal.name
        }
        if (newVal && newVal.location) {
            this.location = newVal.location
        }
        if (newVal && newVal.agendaTopic) {
            this.agendaTopic = newVal.agendaTopic
        }
        if (newVal && newVal.attendees) {
            this.attendees = JSON.parse(newVal.attendees)
        }
        if (newVal && newVal.agendaActions) {
            if(newVal.agendaActions == ''){
                this.agendaActions = []
            }else{
                this.agendaActions = JSON.parse(newVal.agendaActions)
            }
        }
        if(newVal && newVal.cardType){
            this.date = moment(String(newVal.cardType)).format('Do MMM YYYY')
        }
        if (newVal && newVal.cardType) {
            this.cardType = newVal.cardType
        }
        if (newVal && newVal.time) {
            this.time = newVal.time
        }
        if (newVal && newVal.videoId) {
            this.$nextTick(() => {
                this.updateFileSrc("video")
            })
        }
        if (newVal && newVal.audioId) {
            this.$nextTick(() => {
                console.log("Audio"+newVal.audio+"<=>"+newVal.audioId);
                this.updateFileSrc("audio")
            })
        }
    }

    @Watch('$route', { deep: true })
    watchRoute(newVal, oldVal) {
        this.updateRoute(newVal)
    }

    get maxFileSize () {
        if (this.subscription && this.subscription.product && this.storageUsage) {
            return (this.subscription.product.metadata.storageInBytes - this.storageUsage.sizeInBytes) / 1048576
        }
        return 0
    }

    audioDropzoneOptions = {
        url: BASE_URL + '/admin/upload/audio',
        thumbnailWidth: 150,
        maxFiles: 1,
        maxFilesize: this.maxFileSize, // mb
        timeout: 99999999,
        uploadprogress: this.audioUploadProgress
    }

    videoDropzoneOptions = {
        url: BASE_URL + '/admin/upload/video',
        thumbnailWidth: 150,
        maxFiles: 1,
        maxFilesize: this.maxFileSize, // mb
        timeout: 99999999,
        uploadprogress: this.videoUploadProgress
    }

    youtubeDropzoneOptions = {
        url: BASE_URL + '/admin/upload/youtube',
        thumbnailWidth: 150,
        maxFiles: 1,
        maxFilesize: this.maxFileSize, // mb
        timeout: 99999999,
        uploadprogress: this.youtubeUploadProgress
    }

    updateFileSrc(format) {
        store.dispatch('getFileUrl', {
            cardId: this.currentCard.id,
            format: format
        }).then(url => {
            console.log("format is:"+format);
            switch (format) {
                case 'audio': 
                    this.$refs.audio.setAttribute('src', url)
                    console.log("i am in audio case"+url);
                    this.$refs.player.audioSrc = url                    
                break
                case 'video': 
                    this.$refs.video.setAttribute('src', url)
                    this.$refs.mobileVideo.setAttribute('src', url)
                break
                case 'youtube':
                    this.$refs.youtube.setAttribute('src', url)
                    this.$refs.mobileYoutube.setAttribute('src', url)
                break
                default: 
                    console.log('format value is incorrect'+format);
                break;
            }
        })
    }

    videoUploadProgress(file, percent, size) {
        this.videoUploadPercent = Math.round(percent)
    }

    youtubeUploadProgress(file, percent, size) {
        this.youtubeUploadPercent = Math.round(percent)
    }

    videoSendingEvent(file, xhr, formData) {
        this.videoIsUploading = true
        formData.append('cardId', this.currentCard.id)
        formData.append('size', file.size)
    }

    youtubeSendingEvent(file, xhr, formData) {
        this.youtubeIsUploading = true
        formData.append('cardId', this.currentCard.id)
        formData.append('size', file.size)
    }

    audioSendingEvent(file, xhr, formData) {
        this.audioIsUploading = true
        formData.append('cardId', this.currentCard.id)
        formData.append('size', file.size)
    }

    audioUploadProgress(file, percent, size) {
        this.audioUploadPercent = Math.round(percent)
    }

    audioSuccess(file) {
        const payload = {
            courseId: parseInt(this.route.params.courseId),
            unitId: parseInt(this.route.params.unitId),
            cardId: parseInt(this.route.params.cardId),
            file: {
                name: file.name,
                type: 'audio'
            }
        }
        this.audioIsUploading = false
        this.$refs.AudioDropzone.removeAllFiles(true)
        this.currentCard.audio = 
        this.updateFileSrc('audio')
        store.commit('setActiveCardAudio', payload)
        store.dispatch('getStorageUsage')
    }

    videoSuccess(file) {
        const payload = {
            courseId: parseInt(this.route.params.courseId),
            unitId: parseInt(this.route.params.unitId),
            cardId: parseInt(this.route.params.cardId),
            file: {
                name: file.name,
                type: 'video'
            }
        }
        this.videoIsUploading = false
        this.$refs.VideoDropzone.removeAllFiles(true)
        this.updateFileSrc('video')
        store.commit('setActiveCardVideo', payload) // WARNING: this overwrites content edited during upload
        store.dispatch('getStorageUsage')
    }

    youtubeSuccess(file, response) {
        const payload = {
            courseId: parseInt(this.route.params.courseId),
            unitId: parseInt(this.route.params.unitId),
            cardId: parseInt(this.route.params.cardId),
            file: {
                name: response.id,
                type: 'youtube'
            }
        }
        this.youtubeIsUploading = false
        this.$refs.YoutubeDropzone.removeAllFiles(true)
        this.updateFileSrc('youtube')
        store.commit('setActiveCardVideo', payload) // WARNING: this overwrites content edited during upload
        store.dispatch('getStorageUsage')
    }

    removeAudio() {
        if (this.$refs.audio) {
            this.$refs.audio.pause()
        }
        store.commit('set', {
            key: 'removeAudioCardId',
            value: this.$route.params.cardId,
        })
        this.toggleModal('removeAudio')
    }

    removeVideo() {
        if (this.subscription.product.name === 'Free Plan') {
            const youtubeSrc = this.$refs.youtube.src
            this.$refs.youtube.src = youtubeSrc
            const mobileYoutubeSrc = this.$refs.youtube.src
            this.$refs.youtube.src = mobileYoutubeSrc
        } else {
            this.$refs.video.pause()
            this.$refs.video.pause()
        }
        store.commit('set', {
            key: 'removeVideoCardId',
            value: this.$route.params.cardId,
        })
        this.toggleModal('removeVideo')
    }

    updateRoute(route) {
        store.dispatch('getAdmin').then(() => {
            store.dispatch('fetchUnit', parseInt(this.$route.params.unitId))
        })
    }

    fetchUnit() {
        store.dispatch('fetchUnit', parseInt(this.$route.params.unitId))
    }

    mounted() {
        this.updateRoute(this.$route)
        setTimeout(() => {
            this.ready = true
            this.$forceUpdate()
        }, 2000)

        for (let hr = 0; hr < 24; hr++) {
            const H = hr;
            const h = (H % 12) || 12;
            const ampm = H < 12 ? "AM" : "PM";
            const hrStr = h.toString().padStart(2, "0") + ":";
            let val = hrStr + "00"+ampm;
            this.timeSlots.push(val);
            
            val = hrStr + "30"+ampm;
            this.timeSlots.push(val);
          }
    }

    save() {
        if (!this.currentCard) {
            return
        }
        store.dispatch('updateActiveCard', {
            id: this.currentCard.id,
            name: this.name,
            evidence_task: this.evidence,
            content: this.content,
        })
    }

    addAction() {
        const totalAnswers = this.agendaActions.length + 1
        const action:Action= {
            text: ''
        }
        this.agendaActions.push(action)
        console.log(this.agendaActions);
        
        this.$nextTick(() => {
            document.getElementById('action-' + (this.agendaActions.length - 1)).focus()
            document.getElementById('action-' + (this.agendaActions.length - 1)).scrollIntoView(true)
        })
    }
    removeAction(aIndex) {
        this.agendaActions = this.agendaActions.filter((text, i) => i !== aIndex)
        this.savemeeting()
    }
    savemeeting(){
        if (!this.currentCard) {
            return
        }
        store.dispatch('updateActiveCard', {
            id: this.currentCard.id,
            name: this.name,
            location:this.location,
            agendaActions:JSON.stringify(this.agendaActions),
            agendaTopic:this.agendaTopic,
            attendees:JSON.stringify(this.attendees)
        })
    }
}
