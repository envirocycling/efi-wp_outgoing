
// ----------------------- App components -----------------------------------------


/** Outgoing List compoenent */
var OutgoingList = Vue.component('outgoing-list', {
    props: ['outgoings', 'isLoading'],
    template: `

            <div class="row">
                <div class="col-md-12">

                    <table class="table table-striped " v-show="!isLoading">

                        <thead>
                            <tr>
                                <th>Date Out</th>
                                <th>Estimated Date Arrive</th>
                                <th>Branch</th>
                                <th>Str#</th>
                                <th>Trucking</th>
                                <th>Plate#</th>
                                <th>WP Grade</th>
                                <th>Weight</th>
                                <th>Bales</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="outgoing in outgoings" :key="outgoing.id">
                                <td>{{outgoing.date_out}}</td>
                                <td>{{outgoing.date_estimated}}</td>
                                <td>{{outgoing.branch}}</td>
                                <td>{{outgoing.str_no}}</td>
                                <td>{{outgoing.trucking}}</td>
                                <td>{{outgoing.plate_no}}</td>
                                <td>{{outgoing.wp_grade}}</td>
                                <td>{{outgoing.weight}}</td>
                                <td>{{outgoing.bales}}</td>
                                <td>{{outgoing.remarks}}</td>
                            </tr>
                        </tbody>

                    </table>    

                    <h4 style="text-align: center;" v-show="isLoading">Loading...</h4>
                </div>
            </div>
            
    `
})

/** Filtering component */
var FilterComponent = Vue.component('filter-component', {
    template: `
        <div class="row">
        <hr>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: space-between">

                    <form class="form-inline" @submit.prevent="onSubmit">
                      <input class="form-control input-sm" data-provide="datepicker" ref="start_date" value="${moment().format('YYYY-MM-DD')}" data-date-format="yyyy-mm-dd"  style="padding: 1px; width: 124px;text-align: center">
                      to
                      <input class="form-control input-sm" data-provide="datepicker" ref="end_date" value="${moment().format('YYYY-MM-DD')}" data-date-format="yyyy-mm-dd"  style="padding: 1px; width: 124px;text-align: center">

                      <button type="submit" class="btn btn-sm btn-primary" >Submit</button>
                    </form>

                     
                    </div>
                  </div>

                  <br>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input @input="$emit('search', $event.target.value)" class="form-control input-sm" placeholder="Search...">
                      </div>
                    </div>
                  </div>
                </div>
        </div>
    `,
    methods: {
      onSubmit(e) {
        
        this.$emit('datechange', {
          startDate: this.$refs.start_date.value,
          endDate: this.$refs.end_date.value,
        })
      }
    }
});

// ------------------------------------------ End Components -------------------------------------

new Vue({
  el: '#outgoing',
  data: {
    isLoading: true,
    filters: {
      searchField: '',
      start_date: moment().format('YYYY-MM-DD'),
      end_date: moment().format('YYYY-MM-DD')
    },
    outgoings: []
  },
  components: {
    'filter-component': FilterComponent
  },
  methods: {
    search(val) {
      this.filters.searchField = val;
    },
    onChangeDate(dateRange) {

      this.isLoading = true;
      this.searchField = '';

      axios.get(`${window.base_url}/api/outgoings?start_date=${dateRange.startDate}&end_date=${dateRange.endDate}`)
        .then(res => {
          this.outgoings = res.data;
          this.isLoading = false;
      })
      
    }
  },
  computed:  {
    filteredOutgoings() {
      return this.outgoings.filter(outgoing => {
        return outgoing.branch.includes(this.filters.searchField) || outgoing.trucking.includes(this.filters.searchField)
      })
    }
  },
  mounted() {

    axios.get(`${window.base_url}/api/outgoings?start_date=${this.filters.start_date}&end_date=${this.filters.end_date}`)
      .then(res => {
        this.outgoings = res.data;
        this.isLoading = false;
    })

  }
})