import axios from 'axios';
import Computer from '../Components/Computer.vue'
import AddComputer from '../Components/AddComputer.vue'

export default {
    name: 'example',
    components: {
        Computer, AddComputer
    },
    data() {
        return {
            computers: [],
            date: new Date().toISOString().substr(0, 10),
            menuDate: false,
        }
    },

    computed: {},
    created() {
        this.initialize();
    },

    methods: {
        initialize: function () {
            this.computers = [];
            axios.get('/api/computers', {params: {date: this.date}})
                .then(({data}) => {
                    console.log("date", this.date)
                    this.computers = data;
                    console.log("recupération des ordis", data)
                }).catch(error => {
                console.log(error);
            });
        },
        addComputer: function (computer) {
            this.computers.push(computer);
        },
    }
}

