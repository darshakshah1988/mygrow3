
import { Component, Prop, Vue, Inject } from 'vue-property-decorator'
import { State, Getter, Mutation } from 'vuex-class'

import * as vue2Dropzone from 'vue2-dropzone'

import './AddSponsor.scss'
import store from '../../../store'
import axios from 'axios'
import { BASE_URL } from '../../../constants'

@Component({
    template: require('./AddSponsor.html'),
    name: 'AddSponsor',
    components: {
        vueDropzone: vue2Dropzone
    }
})

export class AddSponsor extends Vue {
    @Inject() toggleModal
    @Inject() unitService

    @State activeUnit
    @State route
    @State modals
    @State addCardUnitId

    sponsorName = ''
    submitting = false
    sponsorMessage = ''
    sponsorWebsite = ''
    logo = ''
    dropzoneOptions= {
        url: BASE_URL + '/admin/sponsor/logo',
        thumbnailHeight: 100,
        addRemoveLinks: true,
        acceptedFiles: ".jpg, .jpeg, .png",
        dictDefaultMessage: ``,
        maxFiles: 1,
        thumbnailMethod:'contain'
      }
    $refs: {
        image: HTMLImageElement
    }
    imageSendingEvent(file, xhr, formData) {
        //this.audioIsUploading = true
        //formData.append('cardId', this.currentCard.id)
        formData.append('size', file.size)
    }
    afterComplete(file,response){
        this.logo = response.id
    }
    updateFileSrc(format){
        // store.dispatch('getFileUrl', {
        //     cardId: this.currentCard.id,
        //     format: format
        // }).then(url => {
        //     console.log("format is:"+format);
        //     switch (format) {
        //         case 'image': 
        //             this.$refs.image.setAttribute('src', url)
        //             console.log("i am in audio case"+url);
        //             this.$refs.image.src = url                    
        //         break
        //         default: 
        //             console.log('format value is incorrect'+format);
        //         break;
        //     }
        // })
    }
    submit() {
        if (this.submitting) {
            return
        }
        this.submitting = true
        store.dispatch('addSponsor', {
            courseId: parseInt(this.$route.params.courseId),
            name: this.sponsorName,
            message:this.sponsorMessage,
            website:this.sponsorWebsite,
            logo :this.logo
        }).then(d => {
            this.sponsorName = ''
            this.sponsorWebsite = ''
            this.sponsorMessage = ''
            this.submitting = false
            this.toggleModal('addSponsor')
        })
    }
}

