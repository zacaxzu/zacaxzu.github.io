<template>
  <div id="praktikumi">
    <p id="poruka6">Ovaj tjedan: </p>
    <table border="1">
      <thead>
        <tr>
          <th>Vrijeme</th>
          <th>Ponedjeljak</th>
          <th>Utorak</th>
          <th>Srijeda</th>
          <th>Četvrtak</th>
          <th>Petak</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, rowIndex) in tableData" :key="rowIndex">
          <td>{{ timeSlots[rowIndex] }}</td>
          <td v-for="(cell, columnIndex) in row.slice(1)" :key="columnIndex" contenteditable @input="updateCell(rowIndex, columnIndex + 1, $event)">
            {{ cell }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import h from './../../../server/praktikumi.json?raw';
export default {
  data() {
    return {
      tableData: h,
      // Prvi stupac je vrijeme termina
      timeSlots: ['10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00'],
      ws: null,
    };
  },
  created() {
    // Inicijalizacija tablice sa 6 stupaca i 9 redova
    //this.tableData = Array.from({ length: 8 }, () => Array(6).fill(''));

    // WebSocket povezivanje
    this.ws = new WebSocket('ws://localhost:50100');

    //Inicijalizacija tablice iz json file-a
    this.tableData = h;

    var poruka;
    this.ws.onerror = function(){
      poruka='Live tablica trenutno nije u funkciji! Promjene koje radite neće se zabilježiti.';
      document.getElementById("poruka6").append(poruka);
    };

    this.ws.onmessage = event => {
      const updatedTableData = JSON.parse(event.data);
      this.tableData = updatedTableData;
    };
  },
  methods: {
    updateCell(rowIndex, columnIndex, event) {
      const newValue = event.target.textContent;
      this.tableData[rowIndex][columnIndex] = newValue;

      // Slanje ažurirane tablice WebSocket serveru
      this.ws.send(JSON.stringify(this.tableData));
    },
  },
  beforeUnmount() {
    if (this.ws) {
      this.ws.close();
    }
  },
};
</script>

<style scoped>
table {
  width: 60%;
  border-collapse: collapse;
  background-color: #f2f2f2;
}

th, td {
  width: 16%;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #04AA6D;
}
</style>
