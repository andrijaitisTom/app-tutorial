<template>
	<div id="content" class="app-notestutorial">
		<AppNavigation>
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Agreements')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Agreements','agreements')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Ceo Resolutions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Ceoresolutions','ceoresolutions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Mb decisions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Mbdecisions','mbdecisions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Contracts')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Contracts','contracts')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Sb decisions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Sbdecisions','sbdecisions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Outsourcing Agreements')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('OutsourcingAgreements','outsourcingagreements')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Policies And Instructions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('PoliciesAndInstructions','policiesandinstructions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Sent Or Received Documents')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('SentOrReceivedDocuments','sentorreceiveddocuments')" />
		</AppNavigation>
		<AppContent>
			<div>
				<b-modal id="modal-1"
					ref="info-modal"
					hide-footer
					title="Edit file information">
					<div v-if="currentNote" class="editPanel">
						<div v-for="tableInfo in currentTableInfo" :sort-key="tableInfo.key">
							<label>{{ `${tableInfo.header} :` }}</label>
							<input ref="title"
								v-model="currentNote[tableInfo.key]"
								type="text"
								:disabled="updating"
								:placeholder="currentNote[tableInfo.key]">
						</div>
						<input type="button"
							class="primary"
							:value="t('notestutorial', 'Save')"
							:disabled="updating || !savePossible"
							@click="saveNote">

						<input type="button"
							class="primary"
							:value="t('notestutorial', 'Cancel')"
							@click="cancelNewNote(currentNote)">
					</div>
				</b-modal>
			</div>
			<!-- <div v-else id="emptycontent">
				<div class="icon-file" />
				<h2>{{  t('notestutorial', '...')  }}</h2>
			</div> -->

			<template>
				<div class="container">
					<div class="filtersContainer">
						<div class="form-group">
							<div class="col-auto">
								<label class="form-label text-large mr-2 pr-2">Filter by Name:</label>
							</div>
							<div class="col">
								<input v-model="filters.title.value" class="filterInput">
							</div>
						</div>
						<div class="form-group">
							<div class="col-auto">
								<label class="form-label text-large mr-2 pr-2">Filter by location:</label>
							</div>
							<div class="col">
								<input v-model="filters.location.value" class="filterInput">
							</div>
						</div>
						<div class="form-group">
							<div class="col-auto">
								<label class="form-label text-large mr-2 pr-2">Filter all:</label>
							</div>
							<div class="col">
								<input v-model="filters.all.value" class="filterInput">
							</div>
						</div>
					</div>
					<v-table :data="nodesAndNotes"
						:filters="filters"
						:hide-sort-icons="true"
						class="my-2 table table-striped"
						selection-mode="single"
						selected-class="table-info"
						@selectionChanged="selectedRows = $event">
						<thead slot="head">
							<v-th v-for="tableInfo in currentTableInfo" :sort-key="tableInfo.key">
								<b>{{ tableInfo.header }}</b>
							</v-th>
							<!-- <v-th sort-key="nodeName" default-sort="asc">
								<b>File Name</b>
							</v-th>
							<v-th sort-key="content">
								<b>Content</b>
							</v-th>
							<v-th sort-key="physical">
								<b>Physical Location</b>
							</v-th>
							<v-th sort-key="namelt">
								<b>Name LT</b>
							</v-th>
							<v-th sort-key="mtime">
								<b>Created</b>
							</v-th> -->
						</thead>
						<tbody slot="body" slot-scope="{displayData}">
							<v-tr v-for="row in displayData" :key="row.id" :row="row">
								<td v-for="rowInfo in currentTableInfo">
									<span>{{ row[rowInfo.key] }}</span>
								</td>
								<!-- <td>{{ row.nodeName }}</td>
								<td>{{ row.content }}</td>
								<td>{{ row.physical }}</td>
								<td>{{ row.namelt }}</td> -->
								<td>
									{{ new Date(row.mtime * 1000).toLocaleString('en-GB', { dateStyle: 'short' }) }}
								</td>
								<td>
									<input type="button"
										class="primary"
										:value="t('notestutorial', 'Edit')"
										@click="openEdit(row)">
								</td>

								<td>
									<input type="button"
										class="primary"
										:value="t('notestutorial', 'Open')"
										@click="openFile(row.idfile, row.path )">
								</td>
							</v-tr>
						</tbody>
					</v-table>
				</div>
				<strong>Selected:</strong>
				<div v-if="selectedRows.length === 0" class="text-muted">
					No Rows Selected
				</div>
				<ul>
					<li v-for="selected in selectedRows">
						{{ selected }}
					</li>
				</ul>
			</template>
		</AppContent>
	</div>
</template>

<script>
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationNew from '@nextcloud/vue/dist/Components/AppNavigationNew'

import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'
import users from './users.json'

import tableInfo from './table/tableInfo.json'

export default {
	name: 'App',
	components: {
		ActionButton,
		AppContent,
		AppNavigation,
		AppNavigationItem,
		AppNavigationNew,
	},
	data: () => ({
		name: 'Selection',
		selectedRows: [],
		notes: [],
		nodes: [],
		nodesAndNotes: [],
		notRegistered: [],
		currentNoteId: null,
		updating: false,
		loading: true,
		users,
		currentEndpoint: '',

		tableInfo,
		currentTableInfo: '',

		filters: {
			title: { value: '', keys: ['title'] },
			location: { value: '', keys: ['physicalLocation'] },
			all: { value: '', keys: ['title', 'idfile', 'physicalLocation', 'title', 'content'] },

		},

	}),

	computed: {

		/**
		 * Return the currently selected note object
		 *
		 * @return {object | null}
		 */
		currentNote() {
			if (this.currentNoteId === null) {
				return null
			}

			return this.notes.find((note) => note.id === this.currentNoteId)
		},

		/**
		 * Returns true if a note is selected and its title is not empty
		 *
		 * @return {boolean}
		 */
		savePossible() {
			return this.currentNote && this.currentNote.title !== ''
		},
	},
	/**
	 * Fetch list of notes when the component is loaded
	 */
	async mounted() {

		try {

			const response = await axios.get(generateUrl('/apps/notestutorial/notes'))
			this.notes = response.data
			const nodesResponse = await axios.get(generateUrl('/apps/notestutorial/nodelist/Templates'))
			this.nodes = nodesResponse.data

			const notesIds = []
			const nodesIds = []

			for (let index = 0; index < this.nodes.length; index++) {
				const element = this.nodes[index]
				// console.log(`node ${element.id}`)
				nodesIds.push(element.id)

			}
			for (let index = 0; index < this.notes.length; index++) {
				const element = this.notes[index]
				// console.log(`note ${element.content}`)
				notesIds.push(element.idfile)

			}

			// console.log(`notes ids - ${notesIds} ..... nodes ids -${nodesIds}`)

			const matches = nodesIds.filter(id => !notesIds.includes(JSON.stringify(id)))
			// console.log('matches')
			// console.log(matches)

			for (let index = 0; index < matches.length; index++) {
				const currentID = matches[index]
				const currentObject = this.nodes.find(node => node.id === currentID)
				// console.log(currentObject)
				// const currentFileInfo = {
				// 	id: -1,
				// 	title: currentObject.nodeName,
				// 	content: currentObject.id,
				// 	physical: currentObject.mimetype,
				// 	namelt: currentObject.mimetype,
				// }
				// this.notRegistered.push(currentFileInfo)

				this.createNote({
					id: -1,
					title: JSON.stringify(currentObject.nodeName),
					content: 'N/A',
					physical: 'N/A',
					namelt: 'N/A',
					idfile: JSON.stringify(currentObject.id),
					description: 'N/A',
				})
			}

			this.nodesAndNotes = this.nodes.map(t1 => ({ ...t1, ...this.notes.find(t2 => Number(t2.idfile) === t1.id) }))

			// console.log(this.nodesAndNotes)

		} catch (e) {
			console.error(e)
			showError(t('notestutorial', 'Could not fetch notes'))
		}
		this.loading = false
		// console.log(this.notes)
	},
	/**
	 * Fetch list of nodes when the component is loaded
	 */
	methods: {
		showModal() {
			this.$refs['info-modal'].show()
		},
		hideModal() {
			this.$refs['info-modal'].hide()
		},
		async loadNewFolder(folderName, endpointName) {
			try {
				const response = await axios.get(generateUrl(`/apps/notestutorial/${endpointName}`))
				this.notes = response.data
				const nodesResponse = await axios.get(generateUrl(`/apps/notestutorial/nodelist/${folderName}`))
				this.nodes = nodesResponse.data

				console.log(response)
				this.currentEndpoint = endpointName
				this.currentTableInfo = tableInfo[folderName]

				const notesIds = []
				const nodesIds = []

				for (let index = 0; index < this.nodes.length; index++) {
					const element = this.nodes[index]
					nodesIds.push(element.id)

				}
				for (let index = 0; index < this.notes.length; index++) {
					const element = this.notes[index]
					notesIds.push(element.idfile)

				}

				console.log(nodesIds)
				console.log(notesIds)

				const matches = nodesIds.filter(id => !notesIds.includes(JSON.stringify(id)))

				for (let index = 0; index < matches.length; index++) {
					const currentID = matches[index]
					const currentObject = this.nodes.find(node => node.id === currentID)
					this.createNote({
						id: -1,
						name: JSON.stringify(currentObject.nodeName),
						title: 'N/A 001',
						idfile: JSON.stringify(currentObject.id),
						content: 'N/A 002',
						physical: 'N/A 003',
						namelt: 'N/A 004',
						description: 'N/A 005',
						comments: 'N/A 006',
						outsourcing: 'N/A 007',
						it: 'N/A 008',
						validSince: 'N/A 009',
						validUntil: 'N/A 010',
						form: 'N/A 011',
						firstParty: 'N/A 012',
						secondParty: 'N/A 013',
						physicalLocation: 'N/A 014',
						materiality: 'N/A 015',
						lastRiskAssessmentDate: 'N/A 016',
						relation: 'N/A 017',
						date: 'N/A 018',
						registrationNumberContract: 'N/A 019',
						inForceUntil: 'N/A 020',
						counterparties: 'N/A 021',
						corporateOwner: 'N/A 022',
						personalOwner: 'N/A 023',
						documentType: 'N/A 024',
						registrationNumberCdrmbd: 'N/A 025',
						decisionType: 'N/A 026',
						participants: 'N/A 027',
						documentStatus: 'N/A 028',
						validity: 'N/A 029',
						dateOfTheDocument: 'N/A 030',
						orderType: 'N/A 031',
						registrationNumberCdro: 'N/A 032',
						registrationNumberCdrsbd: 'N/A 033',
						outsourcingFunctionAuditDate: 'N/A 034',
						partiesRelatedToTheCompanyWhoAlsoUseThisService: 'N/A035',
						natureOfFunction: 'N/A036',
						lastRiskAssessmentResult: 'N/A037',
						basisForMateriality: 'N/A038',
						locationOfData: 'N/A039',
						locationOfServices: 'N/A040',
						transferOfData: 'N/A041',
						bankOfLithuaniaApprovalDate: 'N/A042',
						bankOfLithuaniaNotificationDate: 'N/A043',
						isTheServiceProviderRelatedToUabPervesk: 'N/A044',
						agreementApprovedBy: 'N/A045',
						governingLawOfTheAgreement: 'N/A046',
						subcontractors: 'N/A047',
						serviceProviderAddress: 'N/A048',
						serviceProviderLegalEntityCode: 'N/A049',
						serviceProviderName: 'N/A050',
						serviceProviderParentCompany: 'N/A051',
						serviceProviderSubstitutabilityAssessmentResult: 'N/A052',
						alternativeServiceProviders: 'N/A053',
						doesThisFunctionSupportBusinessOperationsCritical: 'N/A054',
						priceOfAgreement: 'N/A055',
						eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel: 'N/A056',
						typePi: 'N/A057',
						approvalDate: 'N/A058',
						responsibleUnit: 'N/A059',
						owner: 'N/A060',
						area: 'N/A061',
						dateReceiptDate: 'N/A062',
						sender: 'N/A063',
						recipient: 'N/A064',
						recipientEmployee: 'N/A065',
						documentForm: 'N/A066',
						deliveryMethod: 'N/A067',
						registrationNumberTd: 'N/A068',
						documentOrganizer: 'N/A069',
						direction: 'N/A070',
					}, endpointName)
				}

				this.nodesAndNotes = this.nodes.map(t1 => ({ ...t1, ...this.notes.find(t2 => Number(t2.idfile) === t1.id) }))

			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not fetch notes'))
			}
			this.loading = false
		},

		/**
		 * open the clicked file
		 *
		 *@param {string} fileId ID of file you wish to open
		 *
		 */
		 openFile(fileId) {
			const host = new URL(window.location.href).origin
			 const redirectTo = `${host}/nextcloud24.0.3/nextcloud/index.php/f/${fileId}`
			 window.open(redirectTo)
		},
		/**
		 * open Editing menu for a row
		 *
		 * @param {object} row Note object
		 */
		 openEdit(row) {
			this.currentNoteId = row.id
			this.$nextTick(() => {
				this.$refs.content.focus()
			})
			this.showModal()
		},
		/**
		 * Create a new note and focus the note content field automatically
		 *
		 * @param {object} note Note object
		 */
		openNote(note) {
			if (this.updating) {
				return
			}
			this.currentNoteId = note.id
			this.$nextTick(() => {
				this.$refs.content.focus()
			})
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new note or save
		 */
		saveNote() {
			this.hideModal()
			if (this.currentNoteId === -1) {
				this.createNote(this.currentNote)
			} else {
				this.updateNote(this.currentNote, this.currentEndpoint)
			}
		},
		/**
		 * Create a new note and focus the note content field automatically
		 * The note is not yet saved, therefore an id of -1 is used until it
		 * has been persisted in the backend
		 */
		newNote() {
			if (this.currentNoteId !== -1) {
				this.currentNoteId = -1
				this.notes.push({
					id: -1,
					title: '',
					content: '',
					physical: '',
					namelt: '',
					idfile: '',
					description: '',
				})
				this.$nextTick(() => {
					this.$refs.title.focus()
				})
			}
		},
		/**
		 * Abort creating a new note
		 */
		cancelNewNote() {
			this.hideModal()
			this.notes.splice(this.notes.findIndex((note) => note.id === -1), 1)
			this.currentNoteId = null
		},
		/**
		 * Create a new note by sending the information to the server
		 *
		 * @param {object} note Note object
		 * @param endpointName
		 */
		async createNote(note, endpointName) {
			this.updating = true
			try {
				// console.log(note)
				const response = await axios.post(generateUrl(`/apps/notestutorial/${endpointName}`), note)
				const index = this.notes.findIndex((match) => match.id === this.currentNoteId)
				this.$set(this.notes, index, response.data)
				// console.log(index)
				this.currentNoteId = response.data.id
			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not create the note'))
			}
			this.updating = false
		},
		/**
		 * Update an existing note on the server
		 *
		 * @param {object} note Note object
		 * @param endpointName
		 */
		async updateNote(note, endpointName) {
			this.updating = true
			try {
				await axios.put(generateUrl(`/apps/notestutorial/${endpointName}/${note.id}`), note)
				location.reload()

			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not update the note'))
			}
			this.updating = false
		},
		/**
		 * Delete a note, remove it from the frontend and show a hint
		 *
		 * if you wish to use it, edit this function to accept endpointName to the axios request instead of current /notes/
		 *
		 * @param {object} note Note object
		 */
		async deleteNote(note) {
			try {
				await axios.delete(generateUrl(`/apps/notestutorial/notes/${note.id}`))
				this.notes.splice(this.notes.indexOf(note), 1)
				if (this.currentNoteId === note.id) {
					this.currentNoteId = null
				}
				showSuccess(t('notestutorial', 'Note deleted'))
			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not delete the note'))
			}
		},
	},
}
</script>
<style scoped>
body {
	padding: 1rem;
	color: #000;
}

thead {
	cursor: pointer;
}

td {
	white-space: nowrap;
}

.vt-sort::after {
	padding-left: 0.5em;
	display: inline-block;
}

.vt-sortable::after {
	content: "\25B2";
	color: transparent;
}

.vt-asc::after {
	content: "\25BC";
}

.vt-desc::after {
	content: "\25B2";
}

#app-content>div {
	width: 100%;
	height: 100%;
	padding: 20px;
	display: flex;
	flex-direction: column;
	flex-grow: 1;
}

input[type='text'] {
	width: 100%;
}

textarea {
	flex-grow: 1;
	width: 100%;
}
.filtersContainer{
	display: flex;
	justify-content: space-evenly;
	padding: 50px 0;
}

.editPanel{
	padding-top: 10px;
}
.filterInput{
	width: 100%;
}

</style>
