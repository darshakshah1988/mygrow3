import { UnitService } from './../../../services/UnitService';
import { state } from './../../../state';
import { Component, Prop, Vue, Inject, Watch } from 'vue-property-decorator'
import { State, Getter, Mutation } from 'vuex-class'

import { BASE_URL } from '../../../constants'

import './AddMentor.scss'
import store from '../../../store'
import axios from 'axios'

@Component({
    template: require('./AddMentor.html'),
    name: 'AddMentor',
    components: {
    }
})

export class AddMentor extends Vue {
    @Inject() studentService
    @Inject() toggleModal

    @Getter registeredStudents

    @State businesses
    @State modals
    @State socket
    @State admin

    @State activeBusinessProfile
    @Watch('activeBusinessProfile', { deep: true })
    watchBusiness(newVal, oldVal) {
        if (newVal) {
            this.businessIds = [newVal.id]
        }
    }

    get showAutosuggest() {
        return this.$route.name === 'course'
    }

    get autosuggestStudents() {
        return this.registeredStudents.filter(student => {
            return student.email.indexOf(this.email) >= 0
        })
    }

    firstName = ''
    lastName = ''
    email = ''
    businessIds = []
    submitting = false
    studentIds=[]
    students=[
        {first_name:'rr',last_name:'qq',email:'qq@gmail.com',id:999},
        // {name:'rose',id:4},
        // {name:'raj',id:5}
    ]
   unique(array, propertyName) {
        return array.filter((e, i) => array.findIndex(a => a[propertyName] === e[propertyName]) === i);
     }
    mounted() {
        //console.log('hello');
        axios.get("http://localhost:5000/admin/student").then(res => {
            //console.log('----res',res)

            const uniqueStudent=this.unique(res.data,'email')          

            //console.log('--unique--',uniqueStudent)
            this.students=uniqueStudent
        })
      }

    selectAutosuggest(email) {
        this.email = email
        this.submit()
    }
    cancelform() {
        console.log("Backdrop clicked");
    }

    submit() {
        

        // console.log(this.studentIds);
        // if (this.submitting) {
        //     return
        // }
        this.submitting = true
        console.log("submitting data");
        console.log(this.email);
        store.dispatch('inviteMentor', {
            // first_name: this.firstName,
            // last_name: this.lastName,
            email: this.email,
            adminId: this.admin.id,
            studentIds:this.studentIds,
            userType: 'mentor',
            name: this.admin.name,
            logo_url: this.admin.logo_url
        }).then(student => {
            this.$ua.trackEvent('Invite Mentor', 'Sent')
            this.firstName = ''
            this.lastName = ''
            this.email = ''
            this.studentIds = []
            this.submitting = false
            this.toggleModal('addMentor')
            // this.$router.push({
            //     name: 'studentProfile',
            //     params: { studentId: student.id }
            // })
        })
    }
}
