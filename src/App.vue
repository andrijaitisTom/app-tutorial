<template>
	<div id="content" class="app-notestutorial" @click="handleNavigationToggle()">
		<AppNavigation class="navigationContainer">
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Agreements')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Agreements', 'agreements')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Ceo Resolutions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Ceoresolutions', 'ceoresolutions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Mb decisions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Mbdecisions', 'mbdecisions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Contracts')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Contracts', 'contracts')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Sb decisions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('Sbdecisions', 'sbdecisions')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Outsourcing Agreements')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="loadNewFolder('OutsourcingAgreements', 'outsourcingagreements')" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Policies And Instructions')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="
					loadNewFolder('PoliciesAndInstructions', 'policiesandinstructions')
				" />
			<AppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'Sent Or Received Documents')"
				:disabled="false"
				button-id="new-notestutorial-button"
				button-class="icon-folder"
				@click="
					loadNewFolder('SentOrReceivedDocuments', 'sentorreceiveddocuments')
				" />
		</AppNavigation>
		<AppContent>
			<div>
				<b-modal id="modal-1"
					ref="info-modal"
					hide-footer
					title="Edit file information">
					<div v-if="currentNote" class="editPanel">
						<form>
							<div v-for="tableInfo in currentTableInfo" :sort-key="tableInfo.key">
								<label>{{ `${tableInfo.header} :` }}</label>
								<input v-if="
										tableInfo.fieldType !== 'date' &&
											tableInfo.fieldType !== 'boolean' &&
											tableInfo.fieldType !== 'choice' &&
											tableInfo.fieldType !== 'number'
									"
									ref="title"
									v-model="currentNote[tableInfo.key]"
									:required="tableInfo.required === 'required'"
									type="text"
									:disabled="updating"
									:placeholder="currentNote[tableInfo.key]">
								<div v-if="tableInfo.fieldType === 'date'">
									<datetime v-model="currentNote[tableInfo.key]"
										type="datetime"
										placeholder="Click to enter date"
										:required="tableInfo.required === 'required'" />
								</div>
								<div v-if="tableInfo.fieldType === 'boolean'" class="radioContainer">
									<input id="yes"
										v-model="currentNote[tableInfo.key]"
										type="radio"
										value="Yes">
									<label for="yes" class="radioLabel">Yes</label>
									<input id="no"
										v-model="currentNote[tableInfo.key]"
										type="radio"
										value="No">
									<label for="no" class="radioLabel">No</label>
								</div>
								<div v-if="tableInfo.fieldType === 'number'">
									<input v-model="currentNote[tableInfo.key]" type="number">
								</div>
								<div v-if="tableInfo.fieldType === 'choice'">
									<select v-model="currentNote[tableInfo.key]">
										<option v-for="option in tableInfo.options" :value="option" >
											{{ option }}
										</option>
									</select>
								</div>
							</div>
							<input type="submit"
								class="primary"
								:value="t('notestutorial', 'Save')"
								:disabled="updating || savePossible"
								@click="saveNote">

							<input type="button"
								class="primary"
								:value="t('notestutorial', 'Cancel')"
								@click="cancelNewNote(currentNote)">
						</form>
					</div>
				</b-modal>
			</div>

			<template>
				<div class="container">
					<div v-if="currentFolderName !== ''" class="filtersContainer">
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
						:class="{
							navigationOpen: isNavigationOpen,
							navigationClosed: !isNavigationOpen,
						}"
						@selectionChanged="selectedRows = $event">
						<thead slot="head">
							<v-th v-for="tableInfo in currentTableInfo" :sort-key="tableInfo.key">
								<b>{{ tableInfo.header }}</b>
							</v-th>
						</thead>
						<tbody slot="body" slot-scope="{ displayData }">
							<v-tr v-for="row in displayData" :key="row.id" :row="row">
								<td v-for="rowInfo in currentTableInfo">
									<span v-if="rowInfo.fieldType !== 'date'">{{
										row[rowInfo.key]
									}}</span>
									<span v-if="rowInfo.fieldType === 'date'">{{
										new Date(row[rowInfo.key]).toLocaleString("lt-LT")
									}}</span>
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
										@click="openFile(row.idfile, row.path)">
								</td>
							</v-tr>
						</tbody>
					</v-table>
				</div>
				<div v-if="currentFolderName === ''" id="emptycontent">
					<div class="icon-file" />
					<h2>
						{{ t("notestutorial", "Select folder on left side to start") }}
					</h2>
				</div>
				<!-- <strong>Selected:</strong>
				<div v-if="selectedRows.length === 0" class="text-muted">
					No Rows Selected
				</div>
				<ul>
					<li v-for="selected in selectedRows">
						{{ selected }}
					</li>
				</ul> -->
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
import { Datetime } from 'vue-datetime'
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
		datetime: Datetime,
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
		dateAndTime: '',
		isNavigationOpen: true,
		currentFolderName: '',

		filters: {
			title: { value: '', keys: ['title'] },
			location: { value: '', keys: ['physicalLocation'] },
			all: {
				value: '',
				keys: ['title', 'idfile', 'physicalLocation', 'title', 'content'],
			},
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
		 * Returns true if one of the required fields in the current opened modal is empty
		 *
		 * @return {boolean}
		 */
		savePossible() {
			const allInputs = []

			for (let index = 0; index < this.currentTableInfo.length; index++) {

				const inputValue = this.currentNote[this.currentTableInfo[index].key]
				const requiredValue = this.currentTableInfo[index].required
				allInputs.push((inputValue !== '' && requiredValue === 'required') || (requiredValue !== 'required'))
			}
			const includesEmptyRequiredInputs = allInputs.includes(false)
			return includesEmptyRequiredInputs

		},
	},
	/**
	 * change loading state after loaded
	 */
	async mounted() {
		this.loading = false
		// console.log(this.notes)
	},

	methods: {
		showModal() {
			this.$refs['info-modal'].show()
		},
		hideModal() {
			this.$refs['info-modal'].hide()
		},
		async loadNewFolder(folderName, endpointName) {
			try {
				const response = await axios.get(
					generateUrl(`/apps/notestutorial/${endpointName}`)
				)
				this.notes = response.data
				const nodesResponse = await axios.get(
					generateUrl(`/apps/notestutorial/nodelist/${folderName}`)
				)
				this.nodes = nodesResponse.data

				// console.log(response)
				this.currentEndpoint = endpointName
				this.currentTableInfo = tableInfo[folderName]
				this.currentFolderName = folderName

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

				// console.log(nodesIds)
				// console.log(notesIds)

				const matches = nodesIds.filter(
					(id) => !notesIds.includes(JSON.stringify(id))
				)

				for (let index = 0; index < matches.length; index++) {
					const currentID = matches[index]
					const currentObject = this.nodes.find(
						(node) => node.id === currentID
					)
					this.createNote(
						{
							id: -1,
							name: JSON.stringify(currentObject.nodeName),
							title: 'N/A',
							idfile: JSON.stringify(currentObject.id),
							content: 'N/A',
							physical: 'N/A',
							namelt: 'N/A',
							description: 'N/A',
							comments: 'N/A',
							outsourcing: 'N/A',
							it: 'N/A',
							validSince: 'N/A',
							validUntil: 'N/A',
							form: 'N/A',
							firstParty: 'N/A',
							secondParty: 'N/A',
							physicalLocation: 'N/A',
							materiality: 'N/A',
							lastRiskAssessmentDate: 'N/A',
							relation: 'N/A',
							date: 'N/A',
							registrationNumberContract: 'N/A',
							inForceUntil: 'N/A',
							counterparties: 'N/A',
							corporateOwner: 'N/A',
							personalOwner: 'N/A',
							documentType: 'N/A',
							registrationNumberCdrmbd: 'N/A',
							decisionType: 'N/A',
							participants: 'N/A',
							documentStatus: 'N/A',
							validity: 'N/A',
							dateOfTheDocument: 'N/A',
							orderType: 'N/A',
							registrationNumberCdro: 'N/A',
							registrationNumberCdrsbd: 'N/A',
							outsourcingFunctionAuditDate: 'N/A',
							partiesRelatedToTheCompanyWhoAlsoUseThisService: 'N/A',
							natureOfFunction: 'N/A',
							lastRiskAssessmentResult: 'N/A',
							basisForMateriality: 'N/A',
							locationOfData: 'N/A',
							locationOfServices: 'N/A',
							transferOfData: 'N/A',
							bankOfLithuaniaApprovalDate: 'N/A',
							bankOfLithuaniaNotificationDate: 'N/A',
							isTheServiceProviderRelatedToUabPervesk: 'N/A',
							agreementApprovedBy: 'N/A',
							governingLawOfTheAgreement: 'N/A',
							subcontractors: 'N/A',
							serviceProviderAddress: 'N/A',
							serviceProviderLegalEntityCode: 'N/A',
							serviceProviderName: 'N/A',
							serviceProviderParentCompany: 'N/A',
							serviceProviderSubstitutabilityAssessmentResult: 'N/A',
							alternativeServiceProviders: 'N/A',
							doesThisFunctionSupportBusinessOperationsCritical: 'N/A',
							priceOfAgreement: 'N/A',
							eventsWhenOutsourcedFunctionWasNotProvidedAtAgreedLevel: 'N/A',
							typePi: 'N/A',
							approvalDate: 'N/A',
							responsibleUnit: 'N/A',
							owner: 'N/A',
							area: 'N/A',
							dateReceiptDate: 'N/A',
							sender: 'N/A',
							recipient: 'N/A',
							recipientEmployee: 'N/A',
							documentForm: 'N/A',
							deliveryMethod: 'N/A',
							registrationNumberTd: 'N/A',
							documentOrganizer: 'N/A',
							direction: 'N/A',
						},
						endpointName
					)
				}

				this.nodesAndNotes = this.nodes.map((t1) => ({
					...t1,
					...this.notes.find((t2) => Number(t2.idfile) === t1.id),
				}))
			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not fetch notes'))
			}
			this.loading = false
		},

		/**
		 * handle navigation closing and opening
		 *
		 *
		 */
		handleNavigationToggle() {
			const navigationElement = document.getElementById('app-navigation-vue')
			if (navigationElement.classList.contains('app-navigation--close')) {
				this.isNavigationOpen = false
				console.log(this.isNavigationOpen)
			} else {
				this.isNavigationOpen = true
				console.log(this.isNavigationOpen)
			}
		},
		/*
		 *
		 * handle time change
		 *
		 *
		 */
		handleDateChange() {
			console.log(this.dateAndTime)
			const timestamp = new Date(this.dateAndTime).valueOf()
			console.log(timestamp)
			console.log(new Date(timestamp))
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
			const splitPath = row.path.split('/')
			const location = splitPath[1]
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
			this.notes.splice(
				this.notes.findIndex((note) => note.id === -1),
				1
			)
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
				const response = await axios.post(
					generateUrl(`/apps/notestutorial/${endpointName}`),
					note
				)
				const index = this.notes.findIndex(
					(match) => match.id === this.currentNoteId
				)
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
				await axios.put(
					generateUrl(`/apps/notestutorial/${endpointName}/${note.id}`),
					note
				)
				// loadNewFolder here works like page reload after info update, because the information showed in the table is taken from Database.
				this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
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

input[type="text"] {
	width: 100%;
}

textarea {
	flex-grow: 1;
	width: 100%;
}

.filtersContainer {
	display: flex;
	justify-content: space-evenly;
	padding: 50px 0;
}

.editPanel {
	padding-top: 10px;
}

.filterInput {
	width: 100%;
}

.container {
	margin: auto 50px;
}
.navigationOpen{
	margin-left: -300px;
}
.navigationClosed{
	margin-left: 0;
}

.navigationOpen td:first-child {
	background-color: #d0e3ff;
	position: -webkit-sticky;
	padding-left: 310px;
	left: 0;
	position: sticky;
}

.navigationOpen th:first-child {
	background-color: #e8f1ff;
	position: -webkit-sticky;
	padding-left: 310px;
	left: 0;
	position: sticky;
}

.navigationClosed td:first-child {
	background-color: #d0e3ff;
	position: -webkit-sticky;
	left: 0;
	position: sticky;
}

.navigationClosed th:first-child {
	background-color: #e8f1ff;
	position: -webkit-sticky;
	left: 0;
	position: sticky;
}

.radioContainer {
	display: flex;
	align-items: center;
}

.radioContainer input {
	cursor: pointer;
}

.radioLabel {
	margin: 0 5px;
}

.vdatetime-input {
	width: 100%;
}
</style>
