<template>
  <div class="p-5">
    <h2 class="text-normal mt-3 mb-3">Home</h2>
    <hr />
    <b-button-group>
      <b-button
        class="m-1"
        @click="action = 'classes'"
        :variant="action == 'classes' ? 'info' : 'outline-info'"
        ><b-icon class="mr-1" icon="list"></b-icon>Classes</b-button
      >
      <b-button
        class="m-1"
        @click="action = 'generate report'"
        :variant="action == 'generate report' ? 'info' : 'outline-info'"
        ><b-icon class="mr-1" icon="pen"></b-icon>Generate Report</b-button
      >
    </b-button-group>
    <div class="card mt-3" v-show="action == 'classes'">
      <div class="card-header">Classes</div>
      <div class="card-body">
        <div class="row">
          <div class="col-4 p-2" v-for="item in classes_items" :key="item.id">
            <b-card :title="item.class_name" :sub-title="item.subject">
              <b-card-text>
                {{ "Students : " + item.students }}
                <br />
                {{ "Level : " + item.year_level }}
              </b-card-text>
            </b-card>
          </div>
        </div>
      </div>
    </div>

    <b-overlay :show="isLoading" rounded="sm">
      <div class="card mt-3" v-show="action == 'generate report'">
        <div class="card-header">Generate Report</div>
        <div class="card-body">
          <form ref="form" @submit.stop.prevent="btnGenerate">
            <b-form-group
              class="mb-2"
              label="Class"
              label-for="classID"
              invalid-feedback="Select a class"
              :state="class_state"
            >
              <b-form-select
                id="class"
                v-model="item.classID"
                :options="classes_options"
                :state="class_state"
                required
                @input="fetchReport(item.classID)"
              ></b-form-select>
            </b-form-group>

            <b-form-group
              class="mb-2"
              label="Year"
              label-for="year"
              invalid-feedback="Select a year"
              :state="class_state"
            >
              <b-form-select
                id="year"
                v-model="item.year"
                :options="year_options"
                :state="year_state"
                required
                :disabled="!item.classID"
              ></b-form-select>
            </b-form-group>

            <b-form-group
              class="mb-2"
              label="Month"
              label-for="month"
              invalid-feedback="Select a month"
              :state="month_state"
            >
              <b-form-select
                id="month"
                v-model="item.month"
                :options="month_options"
                :state="month_state"
                required
                :disabled="!item.year"
              ></b-form-select>
            </b-form-group>

            <!-- <b-form-group
            class="mb-2"
            label="Date"
            label-for="date"
            :invalid-feedback="date_state_text"
            :state="date_state"
          >
            <div class="row justify-content">
              <div class="col">
                <b-form-input
                  id="date1"
                  v-model="date1"
                  type="date"
                  :state="date_state"
                  required
                ></b-form-input>
              </div>
              <div class="col-1 text-center">To</div>
              <div class="col">
                <b-form-input
                  id="date2"
                  v-model="date2"
                  type="date"
                  :state="date_state"
                  required
                ></b-form-input>
              </div>
            </div>
          </b-form-group> -->

            <b-button class="mt-3" variant="info" @click="btnGenerate"
              >Generate</b-button
            >
          </form>
        </div>
      </div>
    </b-overlay>

    <b-modal id="modal_generate_report" ref="modal_generate_report" size="lg">
      <div slot="modal-header">
        <h5 class="modal-title">Attendance Report</h5>
      </div>
      <div class="card mt-3">
        <div class="card-body">
          <div class="h5">{{ class_name }}</div>
          <div class="row justify-content">
            <b-table
              id="report_table"
              class="mt-2"
              show-empty
              striped
              bordered
              hover
              sticky-header
              responsive
              :fields="fields"
              :items="report"
              label-sort-asc=""
              label-sort-desc=""
              label-sort-clear=""
            ></b-table>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button class="m-1" size="sm" variant="info" @click="exportToExcel()"
          ><b-icon class="p-1" icon="table"></b-icon>Export</b-button
        >
        <b-button
          class="m-1"
          size="sm"
          @click="$bvModal.hide('modal_generate_report')"
          ><b-icon class="p-1" icon="x-lg"></b-icon>Close</b-button
        >
      </div>
    </b-modal>
  </div>
</template>
<script>
import firebaseApp from "../../firebase/firebaseConfig";
import { getAuth } from "firebase/auth";
import { getDatabase, ref, onValue } from "firebase/database";
export default {
  data() {
    return {
      item: {
        classID: null,
        year: null,
        month: null,
        // date1: "",
        // date2: "",
      },
      class_state: null,
      year_state: null,
      month_state: null,
      // date_state: null,
      // date_state_text: "",
      action: "classes",
      class_name: "",
      fields: [],
      months: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      classes_items: [],
      classes_options: [{ value: null, text: "Please select a class..." }],
      year_options: [{ value: null, text: "Please select a year..." }],
      month_options: [{ value: null, text: "Please select a month..." }],
      report: [],
      reports: [],
      timeout: null,
      isLoading: false,
    };
  },
  mounted() {
    this.load_item();
  },
  methods: {
    load_item() {
      const db = getDatabase(firebaseApp);
      const auth = getAuth(firebaseApp);

      if (auth) {
        const classes = ref(db, "classes/" + auth.currentUser.uid);
        onValue(classes, (snapshot) => {
          this.classes_items = [];
          const data = snapshot.val();
          var result = Object.keys(data).map((key) => {
            this.classes_options.push({
              value: key,
              text: data[key].class_name,
            });
            this.classes_items.push(data[key]);
          });
        });
      }
    },
    fetchReport(classID) {
      const db = getDatabase();
      const reports = ref(db, "report/" + classID);
      onValue(reports, (snapshot) => {
        this.item.year = null;
        this.year_options = [{ value: null, text: "Please select a year..." }];
        this.item.month = null;
        this.month_options = [
          { value: null, text: "Please select a month..." },
        ];
        const data = snapshot.val();
        this.reports = snapshot.val();
        var result = Object.keys(data).map((key) => {
          this.year_options.push({ value: key, text: key });
        });

        snapshot.forEach((childSnapshot) => {
          var childData = childSnapshot.val();
          var result2 = Object.keys(childData).map((key) => {
            this.month_options.push({ value: key, text: this.months[key - 1] });
          });
        });
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();

      if (this.item.classID != null && this.item.classID != "")
        this.class_state = true;
      else this.class_state = false;
      if (this.item.year != null && this.item.year != "")
        this.year_state = true;
      else this.year_state = false;
      if (this.item.month != null && this.item.month != "")
        this.month_state = true;
      else this.month_state = false;
      // if (this.date1 != "" && this.date2 != "") {
      //   if (
      //     new Date(
      //       this.date1.toString().substring(5, 7) +
      //         "/" +
      //         this.date1.toString().substring(8, 10) +
      //         "/" +
      //         this.date1.toString().substring(0, 4)
      //     ).getTime() <
      //     new Date(
      //       this.date2.toString().substring(5, 7) +
      //         "/" +
      //         this.date2.toString().substring(8, 10) +
      //         "/" +
      //         this.date2.toString().substring(0, 4)
      //     ).getTime()
      //   )
      //     this.date_state = true;
      //   else {
      //     this.date_state_text = "Check date";
      //     this.date_state = false;
      //   }
      // } else {
      //   this.date_state_text = "Enter date";
      //   this.date_state = false;
      // }

      return valid;
    },
    generateReport(students, month, year) {
      var date = new Date(year, month, 0);
      var days = date.getDate();
      this.report = [];
      this.fields = [
        {
          key: this.months[month - 1],
          label: this.months[month - 1],
          stickyColumn: true,
        },
      ];

      setTimeout(() => {
        students.forEach((student) => {
          this.class_name = student.class_name;
          const studentObj = {};
          var month2 = this.months[month - 1];
          for (var i = 1; i <= days; i++) {
            studentObj[month2] = student.student_name;
            this.fields.push({ key: i.toString(), label: i.toString() });
            if (this.reports[year][month][i]) {
              const keys = [];
              Object.keys(this.reports[year][month][i]).map((key) => {
                keys.push(key);
              });
              for (var j = 0; j < keys.length; j++) {
                if (
                  this.reports[year][month][i][keys[j]].studentName ===
                  student.student_name
                ) {
                  studentObj[i.toString()] = "/";
                  break;
                } else {
                  studentObj[i.toString()] = "x";
                }
              }
            } else {
              studentObj[i.toString()] = "x";
            }
          }
          this.report.push(studentObj);
          this.isLoading = false;

          this.$bvModal.show("modal_generate_report");
        });
      }, 2000);
    },
    btnGenerate() {
      if (!this.checkFormValidity()) return;

      this.isLoading = true;

      const db = getDatabase();
      const student_item = [];
      const students = ref(db, "students/" + this.item.classID);
      onValue(students, (snapshot) => {
        snapshot.forEach((childSnapshot) => {
          student_item.push(childSnapshot.val());
        });
      });
      this.generateReport(student_item, this.item.month, this.item.year);
    },
    exportToExcel() {
      var tab_text =
        "<table border='2px'><tr><td style='font-weight: bold; font-size: 25px'>" +
        this.class_name +
        "</td></tr><tr>";
      var textRange;
      var j = 0;
      var tab = document.getElementById("report_table"); // id of table

      for (j = 0; j < tab.rows.length; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        //tab_text=tab_text+"</tr>";
      }

      tab_text = tab_text + "</table>";
      tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
      tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
      tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");
      var sa;

      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        // If Internet Explorer
        txtArea1.document.open("txt/html", "replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa = txtArea1.document.execCommand("SaveAs", true, "");
      } //other browser not tested on IE 11
      else
        sa = window.open(
          "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
        );

      return sa;
    },
  },
};
</script>
