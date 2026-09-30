const SSE_URL = BASE_URL; // URL de votre fichier PHP

let eventSource = null;
let lineCount = 0;

function setLoadIcon(batch, html) {
    const el = document.getElementById(`load_div_${batch}`);
    if (el) {
        el.innerHTML = html;
    }
}

function setTime(batch,type) {
    const el = document.getElementById(`${batch}${type}`);    
    let now = new Date();
    
    if (el) {
        el.innerHTML = now.toLocaleTimeString();
    }
}

function setCheck(item,value) {
    const el = document.getElementById(`${item}`); 
    
    if (el) {
        el.innerHTML = value;
    }

    if(item.startsWith("st_")){
        START = value;
    }else{
        const batch = item.replace(/^end_/, '');
        END = value;
        PROCESS = START-END;
        setCheck('pr_'+batch,PROCESS); 
    }
}

function addLine(text, type = 'log') {
    const output = document.getElementById('output');
    const output1 = document.getElementById('output1');

    // Supprimer le curseur clignotant s'il existe
    const cursorLine = output1.querySelector('.line:last-child');
    if (cursorLine && cursorLine.querySelector('.cursor')) {
        cursorLine.remove();
    }

    const now = new Date();
    const ts = now.toTimeString().slice(0, 8);

    const line = document.createElement('div');
    line.className = `line ${type}`;
    line.innerHTML = `
      <span class="ts">${ts}</span>
      <span class="prompt">${type === 'log' ? '$' : type === 'info' ? '•' : type === 'warn' ? '!' : '✗'}</span>
      <span class="line-text">${escapeHtml(text)}</span>
    `;
    output1.appendChild(line);

    let line0 = `
            ${ts} ${type === 'log' ? '$' : type === 'info' ? '•' : type === 'warn' ? '!' : '✗'} ${escapeHtml(text)}
        `;
    lineCount++;
    // output.value += line0;
    // Auto-scroll
    // output.scrollTop = output.scrollHeight;
    output1.scrollTop = output1.scrollHeight;
}

function escapeHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function setStatus(state, text) {
    const dot = document.getElementById('status-dot');
    const label = document.getElementById('status-text');
    dot.className = state;
    label.textContent = text;
}

let START=0,END=0,PROCESS=0;
async function startExecution(serveur, batch, args) {
    setTime(batch,'-startdate');
    checkScript(batch,'st_'+batch);
    if (eventSource) {
        eventSource.close();
        eventSource = null;
    }

    clearOutput(false);
    
    setStatus('running', 'Connexion en cours...');
    setLoadIcon(
        batch,
        '<div class="loader" style="display:block;"></div>'
    );

    let URL = BASE_URL + `/batch/execute/${serveur}/${batch}/${args}`;
    if (args == "") {
        URL = BASE_URL + `/batch/execute/${serveur}/${batch}/0`;
    }
    console.log(URL);
    eventSource = new EventSource(URL);


    eventSource.addEventListener('log', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'log');
        setStatus('running', `${lineCount} lignes reçues`);
    });

    eventSource.addEventListener('info', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'info');
    });

    eventSource.addEventListener('warn', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'warn');
    });

    eventSource.addEventListener('error_msg', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'error');
    });

    eventSource.addEventListener('done', () => {
        addLine('Script terminé.', 'done');
        eventSource.close();
        eventSource = null;
        //   document.getElementById('btn-run').disabled = false;
        setStatus('done', `Terminé — ${lineCount} lignes`);
        setLoadIcon(
            batch,
            '<span class="fas fa-check fa-2x text-success"></span>'
        );
        setTime(batch,'-enddate');
        checkScript(batch,'end_'+batch);
    });

    eventSource.onerror = () => {
        if (eventSource && eventSource.readyState === EventSource.CLOSED) {
            addLine('Connexion SSE fermée.', 'warn');
            setLoadIcon(
                batch,
                '<span class="fas fa-exclamation-triangle fa-2x text-danger"></span>'
            );

        } else {
            addLine('Erreur de connexion SSE.', 'error');
            setStatus('error', 'Erreur');
            setLoadIcon(
                batch,
                '<span class="fas fa-warning fa-2x text-danger"></span>'
            );
        }
        setTime(batch,'-enddate');
        checkScript(batch,'end_'+batch);
        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }
        
    };
}

function clearOutput(keepReady = true) {
    const output = document.getElementById('output1');
    output.innerHTML = '';
    lineCount = 0;
    if (keepReady) {
        output.innerHTML = `
        <div class="line info">
          <span class="prompt">$</span>
          <span class="line-text">Terminal effacé. Prêt.</span>
        </div>
        <div class="line log"><span class="cursor"></span></div>
      `;
        setStatus('', 'En attente');
    }
}

async function check(batch) {
    document.getElementById('check_' + batch).innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';
    try {
        let URL = BASE_URL + `/batch/check/${batch}`;
        const response = await fetch(URL);

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        const data = await response.json();
        // alert(data);
        document.getElementById('check_' + batch).innerHTML = data;
    } catch (error) {
        console.error('Erreur:', error);
    }
}

async function checkScript(batch,label) {
    try {
        let URL = BASE_URL + `/batch/check/${batch}`;
        const response = await fetch(URL);

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        const data = await response.json();
        
        setCheck(label,data);
    } catch (error) {
        console.error('Erreur:', error);
    }
}


const regex = /^\d{4}-\d{2}-\d{2}$/;
let deposedate;
async function change_fechab() {
    let fechval = document.getElementById('inp_fechab').value;
    if (regex.test(fechval)) {
        let treat = fechval.replaceAll('-', '');
        startExecution(162, 'Sfechab', treat);
    } else {
        alert("Mauvaise date");
    }

}

async function depose(type) {
    let batch = 'depose_bt';
    if (type == "BT") {
        deposedate = document.getElementById('inp_depose_bt').value;
    } else {
        deposedate = document.getElementById('inp_depose_mt').value;
        batch = 'depose_mt';
    }

    if (regex.test(deposedate)) {
        let treat = deposedate.replaceAll('-', '');
        startExecution(162, batch, treat);
    } else {
        alert("Mauvaise date");
    }

    // startExecution(200, batch, treat);
}

async function gen_borderau() {
    startExecution(200, 'gen_bordereau', '0');
}

async function checkfacture() {
    document.getElementById('check_nbr_facture').innerHTML = '<i class="fas fa-hourglass-half"></i>';
    let fechval = document.getElementById('inp_facture').value;
    if (regex.test(fechval)) {
        let treat = fechval.replaceAll('-', '_');
        try {
            let URL = BASE_URL + `/batch/checkfacture/${treat}`;
            const response = await fetch(URL);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            const data = await response.json();
            // alert(data);
            document.getElementById('check_nbr_facture').innerHTML = data;
        } catch (error) {
            console.error('Erreur:', error);
        }
    } else {
        alert("Mauvaise date");
    }

}

async function kill(serveur, batch) {
    // output.value = '';
    if (eventSource) {
        eventSource.close();
        eventSource = null;
    }

    // clearOutput(false);
    setStatus('running', 'Connexion en cours...');

    let URL = BASE_URL + `/batch/kill/${serveur}/${batch}`;

    console.log(URL);
    eventSource = new EventSource(URL);


    eventSource.addEventListener('log', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'log');
        setStatus('running', `${lineCount} lignes reçues`);
    });

    eventSource.addEventListener('info', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'info');
    });

    eventSource.addEventListener('warn', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'warn');
    });

    eventSource.addEventListener('error_msg', e => {
        const data = JSON.parse(e.data);
        addLine(data.text, 'error');
    });

    eventSource.addEventListener('done', () => {
        addLine('Script terminé.', 'done');
        eventSource.close();
        eventSource = null;
        //   document.getElementById('btn-run').disabled = false;
        setStatus('done', `Terminé — ${lineCount} lignes`);
    });

    eventSource.onerror = () => {
        if (eventSource && eventSource.readyState === EventSource.CLOSED) {
            addLine('Connexion SSE fermée.', 'warn');

        } else {
            addLine('Erreur de connexion SSE.', 'error');
            setStatus('error', 'Erreur');
        }
        //   document.getElementById('btn-run').disabled = false;
        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }
    };
}

// async function download_bordereau() {

//     let fechval = document.getElementById('inp_get_bordereau').value;
//     if (regex.test(fechval)) {
//         let treat = fechval.replaceAll('-', '');
//         const response = await fetch(BASE_URL + `/batch/get_bordereau/${treat}`);

//         const total = Number(response.headers.get('Content-Length'));

//         const reader = response.body.getReader();

//         let received = 0;
//         const chunks = [];

//         while (true) {

//             const { done, value } = await reader.read();

//             if (done) {
//                 break;
//             }

//             chunks.push(value);

//             received += value.length;

//             const percent = Math.round(received * 100 / total);

//             document.getElementById('progress').value = percent;
//             document.getElementById('percent').textContent = percent + '%';
//         }

//         const blob = new Blob(chunks, { type: 'application/zip' });

//         const url = URL.createObjectURL(blob);

//         const a = document.createElement('a');
//         a.href = url;
//         a.download = `BORDEREAU_DVC_${treat}.zip`;
//         a.click();

//         URL.revokeObjectURL(url);

//     } else {
//         alert("Mauvaise date");
//     }

// }

async function download_bordereau() {

    let fechval = document.getElementById('inp_get_bordereau').value;

    if (!regex.test(fechval)) {
        alert("Mauvaise date");
        return;
    }

    let treat = fechval.replaceAll('-', '');

    try {

        const response = await fetch(BASE_URL + `/batch/get_bordereau/${treat}`);

        // Vérifier si le fichier existe
        if (!response.ok) {

            if (response.status === 404) {
                alert("Le fichier n'existe pas.");
            } else {
                alert("Erreur lors du téléchargement.");
            }

            return;
        }

        const total = Number(response.headers.get('Content-Length'));

        const reader = response.body.getReader();

        let received = 0;
        const chunks = [];

        while (true) {

            const { done, value } = await reader.read();

            if (done) break;

            chunks.push(value);

            received += value.length;

            if (total > 0) {
                const percent = Math.round(received * 100 / total);
                document.getElementById('progress').value = percent;
                document.getElementById('percent').textContent = percent + '%';
            }
        }

        const blob = new Blob(chunks, { type: 'application/zip' });

        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = `BORDEREAU_DVC_${treat}.zip`;
        a.click();

        URL.revokeObjectURL(url);

    } catch (err) {
        console.error(err);
        alert("Impossible de contacter le serveur.");
    }
}

async function checkItin() {
    document.getElementById('check_Itin').innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';
    let fechval = document.getElementById('inp_Itin').value;
    if (regex.test(fechval)) {
        let treat = fechval.replaceAll('-', '_');
        try {
            let URL = BASE_URL + `/batch/checkitin/${treat}`;
            console.log(URL);
            const response = await fetch(URL);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            const data = await response.json();
            // alert(data);
            document.getElementById('check_Itin').innerHTML = data;
        } catch (error) {
            console.error('Erreur:', error);
        }
    } else {
        alert("Mauvaise date");
    }

}

async function uploadAnomalieCSV(){

    const fileInput = document.getElementById('inp_csv_anomalie');
    const result = document.getElementById('result_upload_anomalie');

    result.innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';

    if (!fileInput.files.length) {
        result.innerHTML = '<span class="text-danger">Veuillez sélectionner un fichier CSV.</span>';
        return;
    }

    const file = fileInput.files[0];

    try {

        // Lire le fichier
        const text = await file.text();

        // Découper en lignes
        const lines = text.split(/\r?\n/);

        // Récupérer la première colonne
        const values = [];

        lines.forEach((line, index) => {

            line = line.trim();

            // Ignorer les lignes vides
            if (!line) {
                return;
            }

            // CSV séparé par ;
            const columns = line.split(';');

            // Première colonne
            const value = columns[0].trim();

            if (value) {
                values.push(value);
            }
        });

        console.log(values);

        if (values.length === 0) {
            result.innerHTML =
                '<span class="text-danger">Aucune donnée trouvée.</span>';
            return;
        }

        // Envoyer les données au PHP
        const response = await fetch(
            BASE_URL + '/batch/upload_anomalie_mt_csv',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    values: values
                })
            }
        );

        if (!response.ok) {
            throw new Error('Erreur HTTP : ' + response.status);
        }

        const data = await response.text();

        result.innerHTML =
            '<span class="text-success">' +
            data +
            '</span>';

    } catch (error) {

        console.error(error);

        result.innerHTML =
            '<span class="text-danger">' +
            error.message +
            '</span>';
    }
}

async function uploadAnomalie(){

    const Input = document.getElementById('inp_anomalie');
    const result = document.getElementById('result_upload_anomalie');

    result.innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';
    
    const values = [Input.value];

    try {

        console.log(values);

        if (values.length === 0) {
            result.innerHTML =
                '<span class="text-danger">Aucune donnée trouvée.</span>';
            return;
        }

        // Envoyer les données au PHP
        const response = await fetch(
            BASE_URL + '/batch/upload_anomalie_mt',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    values: values
                })
            }
        );

        if (!response.ok) {
            throw new Error('Erreur HTTP : ' + response.status);
        }

        const data = await response.text();

        result.innerHTML =
            '<span class="text-success">' +
            data +
            '</span>';

    } catch (error) {

        console.error(error);

        result.innerHTML =
            '<span class="text-danger">' +
            error.message +
            '</span>';
    }
}

async function downloadAnomalieMtCopie() {

    const result = document.getElementById('result_upload_anomalie');
    try {

        const response = await fetch(BASE_URL + `/batch/downloadAnomalieMtCopie`);

        result.innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';

        // Vérifier si le fichier existe
        if (!response.ok) {

            if (response.status === 404) {
                alert("Le fichier n'existe pas.");
            } else {
                alert("Erreur lors du téléchargement.");
            }
            result.innerHTML = '';

            return;
        }

        const total = Number(response.headers.get('Content-Length'));

        const reader = response.body.getReader();

        let received = 0;
        const chunks = [];

        while (true) {

            const { done, value } = await reader.read();

            if (done) break;

            chunks.push(value);

            received += value.length;

            if (total > 0) {
                const percent = Math.round(received * 100 / total);
                document.getElementById('progress_ano_mt').value = percent;
                document.getElementById('percent_ano_mt').textContent = percent + '%';
            }
        }

        const blob = new Blob(chunks, { type: 'application/zip' });

        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = `AnomalieMT.csv`;
        a.click();

        URL.revokeObjectURL(url);
        result.innerHTML = '';

    } catch (err) {
        console.error(err);
        alert("Impossible de contacter le serveur.");
        result.innerHTML = '';
    }
}

async function change_cycle() {
    let fechval = document.getElementById('inp_cycle').value;
    if (fechval !== '' && !Number.isNaN(Number(fechval)) && fechval > 0 && fechval <= 12) {
        await startExecution(162, 'scycle162', fechval);
    } else {
        alert("Mauvaise Cycle");
    }

}

async function checkbatchMT(batch) {
    document.getElementById(`check_${batch}`).innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';
    try {
        let URL = BASE_URL + `/batch/checkitin/${batch}`;
        console.log(URL);
        const response = await fetch(URL);

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        const data = await response.json();
        // alert(data);
        document.getElementById(`check_${batch}`).innerHTML = data;
    } catch (error) {
        console.error('Erreur:', error);
    }

}

async function BlockAnoMT() {
    document.getElementById(`check_${batch}`).innerHTML = '<i class="fas fa-hourglass-half fa-spin"></i>';
    try {
        let URL = BASE_URL + `/batch/block_anomalie_mt`;
        console.log(URL);
        const response = await fetch(URL);

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        const data = await response.json();
        await checkbatchMT('block_ano_mt');
    } catch (error) {
        console.error('Erreur:', error);
    }

}