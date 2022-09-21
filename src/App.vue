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
										<option v-for="option in tableInfo.options" :value="option">
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
									<input :ref="`${row.nodeName}`"
										type="button"
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
				<strong>Selected:</strong>
				<div v-if="selectedRows.length === 0" class="text-muted">
					No Rows Selected
				</div>
				<ul>
					<li v-for="selected in selectedRows">
						{{ selected }}
					</li>
				</ul>
				<button v-if="currentFolderName !== ''" @click="toggleFileUploadMenu()">
					Upload new file
				</button>
				<template v-if="showFileUploadMenu">
					<Content :class="{'icon-loading': loading}" app-name="flowupload">
						<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

						<!-- CONTENT -->
						<AppContent>
							<div v-if="!loading" v-activeLocationFileDropZone style="margin-left: 4%; margin-right: 4%; margin-top: 7px; width:auto">
								<div v-if="activeLocation === undefined" id="noLocationSelected">
									{{ t('flowupload', 'Please select a location') }}
								</div>
								<div v-if="activeLocation != undefined" id="locationSelected">
									<h2 id="title">
										{{ t('flowupload', `Upload files to ${currentFolderName}`) }}
									</h2>
									<div class="buttonGroup">
										<span v-uploadSelectButton class="button" uploadtype="file">
											<span class="icon icon-file select-file-icon" />
											<span>{{ t('flowupload', 'Select File') }}</span>
										</span>
										<input id="FileSelectInput"
											type="file"
											@change="filesSelected">
										<span v-show="activeLocation.flow.supportDirectory"
											v-uploadSelectButton
											class="button"
											uploadtype="folder">
											<span class="icon icon-files" style="background-image: var(--icon-files-000);" />
											<span>{{ t('flowupload', 'Select Folder +++') }}</span>
										</span>
										<input id="FolderSelectInput"
											type="file"
											multiple="multiple"
											webkitdirectory="webkitdirectory"
											@change="filesSelected">
									</div>
									<hr>
									<div class="buttonGroup">
										<a class="button" @click="activeLocation.flow.resume()">
											<span class="icon icon-play" />
											<span>{{ t('flowupload', 'Start/Resume') }}</span>
										</a>
										<a class="button" @click="activeLocation.flow.pause()">
											<span class="icon icon-pause" />
											<span>{{ t('flowupload', 'Pause') }}</span>
										</a>
										<a class="button" @click="activeLocation.flow.cancel()">
											<span class="icon icon-close" />
											<span>{{ t('flowupload', 'Cancel') }}</span>
										</a>
										<a id="hideFinishedButton" class="button" @click="hideFinished = !hideFinished">
											<input v-model="hideFinished" type="checkbox">
											<span>{{ t('flowupload', 'Hide finished uploads') }}</span>
										</a>
									</div>
									<hr>
									<p>
										<span class="label">{{ t('flowupload', 'Size') + ' : ' + bytes(activeLocation.flow.getSize()) }}</span>
										<span v-if="activeLocationFilesCount != 0" class="label">{{ t('flowupload', 'Progress') + ' : ' + trimDecimals(activeLocation.flow.progress()*100, 2) + '%' }}</span>
										<span v-if="activeLocation.flow.isUploading()" class="label">{{ t('flowupload', 'Time remaining') + ' : ' + seconds(activeLocation.flow.timeRemaining()) }}</span>
										<span v-if="activeLocation.flow.isUploading()" class="label">{{ t('flowupload', 'Uploading') + '...' }}</span>
									</p>
									<hr>
									<table id="uploadsTable">
										<thead>
											<tr>
												<th class="hideOnMobile" style="width:5%">
													<span class="noselect">#</span>
												</th>
												<th @click="selectSortingMethod('name')">
													<a class="noselect">
														<span>{{ t('flowupload', 'Name') }}</span>
														<span :class="{'icon-triangle-n': (sort == 'name' && sortReverse), 'icon-triangle-s': (sort == 'name' && !sortReverse)}" class="sortIndicator" />
													</a>
												</th>
												<th />
												<th class="hideOnMobile" style="width:10%" @click="selectSortingMethod('uploadspeed')">
													<a class="noselect">
														<span>{{ t('flowupload', 'Upload speed') }}</span>
														<span :class="{'icon-triangle-n': (sort == 'uploadspeed' && sortReverse), 'icon-triangle-s': (sort == 'uploadspeed' && !sortReverse)}" class="sortIndicator" />
													</a>
												</th>
												<th style="width:10%" @click="selectSortingMethod('size')">
													<a class="noselect">
														<span>{{ t('flowupload', 'Size') }}</span>
														<span :class="{'icon-triangle-n': (sort == 'size' && sortReverse), 'icon-triangle-s': (sort == 'size' && !sortReverse)}" class="sortIndicator" />
													</a>
												</th>
												<th style="width:20%" @click="selectSortingMethod('progress')">
													<a class="noselect">
														<span>{{ t('flowupload', 'Progress') }}</span>
														<span :class="{'icon-triangle-n': (sort == 'progress' && sortReverse), 'icon-triangle-s': (sort == 'progress' && !sortReverse)}" class="sortIndicator" />
													</a>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(file, index) in filteredFiles" :key="'file-' + file.uniqueIdentifier">
												<td class="hideOnMobile">
													{{ index+1 }}
												</td>
												<td class="ellipsis" :title="'UID: ' + file.uniqueIdentifier">
													<span>{{ file.relativePath }}</span>
												</td>
												<td>
													<div v-if="!file.isComplete() || file.error" class="actions">
														<a v-if="!file.isUploading() && !file.error"
															class="action permanent"
															:title="t('flowupload', 'Resume')"
															@click="file.resume()">
															<span class="icon icon-play" />
														</a>
														<a v-if="file.isUploading() && !file.error"
															class="action permanent"
															:title="t('flowupload', 'Pause')"
															@click="file.pause()">
															<span class="icon icon-pause" />
														</a>
														<a v-show="file.error"
															class="action permanent"
															:title="t('flowupload', 'Retry')"
															@click="file.retry()">
															<span class="icon icon-play" />
														</a>
														<a class="action permanent" :title="t('flowupload', 'Cancel')" @click="file.cancel()">
															<span class="icon icon-close" />
														</a>
													</div>
												</td>
												<td class="hideOnMobile">
													<span v-if="file.isUploading()">{{ byterate(file.currentSpeed) }}</span>
												</td>
												<td :title="'Chunks: ' + completedChunks(file) + ' / ' + file.chunks.length">
													<span v-if="!file.isComplete()" class="hideOnMobile">{{ bytes(file.size*file.progress()) }}/</span>
													<span>{{ bytes(file.size) }}</span>
												</td>
												<td>
													<progress v-if="!file.isComplete() && !file.error"
														class="progressbar hideOnMobile"
														max="1"
														:value="file.progress()" />
													<span v-if="!file.isComplete() && !file.error">{{ trimDecimals(file.progress()*100, 2) }}%</span>
													<span v-if="file.isComplete() && !file.error">{{ t('flowupload', 'Completed') }}</span>
													<i v-if="file.isComplete() && !file.error">{{ afterFileUpload }}</i>
													<span v-if="file.error">{{ t('flowupload', 'Error') }}</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</AppContent>
					</Content>
				</template>
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
import AppNavigationCounter from '@nextcloud/vue/dist/Components/AppNavigationCounter'
import Flow from '@flowjs/flow.js'
import Content from '@nextcloud/vue/dist/Components/Content'
import locationsJson from './table/locations.json'
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
		Content,
		AppNavigationCounter,
	},
	directives: {
		customLocationFileDropZone: {
			inserted(elm, binding, vnode) {
				const self = vnode.context
				const flow = binding.arg.flow

				elm.addEventListener('drop', function(event) {
					const dataTransfer = event.dataTransfer

					if (dataTransfer.items && dataTransfer.items[0]
						&& dataTransfer.items[0].webkitGetAsEntry) {
						flow.webkitReadDataTransfer(event)
					} else {
						flow.addFiles(dataTransfer.files, event)
					}
				})
				self.addListenerMulti(elm, 'drag dragstart dragend dragover dragenter dragleave drop', function(e) {
					e.preventDefault()
					e.stopPropagation()
				})
				self.addListenerMulti(elm, 'dragover dragenter', function() {
					elm.classList.add('fileDrag')
				})
				self.addListenerMulti(elm, 'dragleave dragend drop', function() {
					elm.classList.remove('fileDrag')
				})
			},
		},
		activeLocationFileDropZone: {
			inserted(elm, binding, vnode) {
				const self = vnode.context

				elm.addEventListener('drop', function(event) {
					const dataTransfer = event.dataTransfer

					if (dataTransfer.items && dataTransfer.items[0]
						&& dataTransfer.items[0].webkitGetAsEntry) {
						self.activeLocation.flow.webkitReadDataTransfer(event)
					} else {
						self.activeLocation.flow.addFiles(dataTransfer.files, event)
					}
				})
				self.addListenerMulti(elm, 'drag dragstart dragend dragover dragenter dragleave drop', function(e) {
					e.preventDefault()
					e.stopPropagation()
				})
				self.addListenerMulti(elm, 'dragover dragenter', function() {
					elm.classList.add('fileDrag')
				})
				self.addListenerMulti(elm, 'dragleave dragend drop', function() {
					elm.classList.remove('fileDrag')
				})
			},
		},
		uploadSelectButton: {
			inserted(elm, binding, vnode) {
				const uploadType = elm.getAttribute('uploadType')

				if (uploadType === 'file') {
					elm.addEventListener('click', function() {
						document.getElementById('FileSelectInput').click()
					})
				} else if (uploadType === 'folder') {
					elm.addEventListener('click', function() {
						document.getElementById('FolderSelectInput').click()
					})
				}
			},
		},
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
		showFileUploadMenu: false,

		locations: [],
		baseUrl: generateUrl('/apps/flowupload'),
		currentLocation: undefined,
		hideFinished: false,
		activeLocationPath: false,
		sort: 'name',
		sortReverse: false,
		search: '',
		recentlyUploadedFileName: '',

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
		activeLocation() {
			if (this.activeLocationPath) {
				return this.getLocationByPath(this.activeLocationPath)
			} else {
				return undefined
			}
		},
		filteredFiles() {
			if (this.activeLocation.flow) {
				let sorted

				if (this.hideFinished) {
					sorted = [...this.activeLocation.flow.files].filter(function(file) {
				        return !file.isComplete()
				    })
				} else {
					sorted = [...this.activeLocation.flow.files]
				}

				if (this.sort === 'name') {
					sorted = sorted.sort(function(a, b) {
						const nameA = a.relativePath.toLowerCase()
						const nameB = b.relativePath.toLowerCase()
						if (nameA < nameB) { // sort string ascending
							return -1
						}
						if (nameA > nameB) {
							return 1
						}
						return 0 // default return value (no sorting)
					})
				} else if (this.sort === 'size') {
					sorted = sorted.sort(function(a, b) {
						return b.size - a.size
					})
				} else if (this.sort === 'progress') {
					sorted = sorted.sort(function(a, b) {
						return b.progress() - a.progress()
					})
				} else if (this.sort === 'uploadspeed') {
					sorted = sorted.sort(function(a, b) {
						return b.averageSpeed - a.averageSpeed
					})
				}

				if (this.sortReverse) {
					sorted.reverse()
				}

				if (this.search !== '') {
				    sorted = sorted.filter(function(file) {
				        return file.relativePath.toLowerCase().includes(this.search.toLowerCase())
				    })
				}

				return sorted
			} else {
				return []
			}
		},
		activeLocationFilesCount() {
			if (this.activeLocation.flow.getFilesCount) {
				return this.activeLocation.flow.getFilesCount()
			} else {
				return 0
			}
		},
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
		afterFileUpload() {
			// if (this.filteredFiles[0].isComplete()) {
			console.log('after file upload')
			console.log(this.filteredFiles[0].name)
			// if (this.filteredFiles[0].isComplete() && !this.filteredFiles[0].error) {
			const uploadedFileName = this.filteredFiles[0].name
			// console.log(this.recentlyUploadedFileName)
			this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
			setTimeout(() => {
				console.log('Delayed for 1 second.')
				this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
				console.log(this.$refs)
			}, '1000')

			setTimeout(() => {
				console.log('Delayed for 1 second.')
				this.$refs[uploadedFileName][0].click()

			}, '3000')
			this.activeLocation.flow.cancel()



			return null
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
		filesSelected(event) {
			this.activeLocation.flow.addFiles(event.target.files)
			document.querySelectorAll('#FileSelectInput, #FolderSelectInput').value = null
		},
		setupDynamicTitleInterval() {
			const self = this
			setInterval(function() {
				self.updateTitle()
			}, 500)
		},
		setupSearch() {
		    const self = this
		    this.OCASearch = new OCA.Search(function(value) {
				self.search = value
		    }, function() {
		        self.search = ''
		    })
		},
		updateTitle() {
			if (this.activeLocation !== undefined && this.activeLocation.flow.files.length !== 0) {
				const progress = parseFloat(Math.round(this.activeLocation.flow.progress() * 100 * 100) / 100).toFixed(2) // round to two digits after comma
				document.title = 'FlowUpload ' + progress + '%'
			} else {
				document.title = 'FlowUpload'
			}
		},
		switchActiveLocationById(id) {
			const location = this.getLocationById(id)
			// console.log('location')
			// console.log(location)
			// console.log(this.activeLocationPath)

			this.activeLocationPath = location.path
		},
		switchActiveLocationByPath(path) {

			this.activeLocationPath = path

			// console.log(this.currentFolderName)
			console.log(this.activeLocationPath)
		},

		// loadLocations() {
		// 	const self = this
		// 	return new Promise(function(resolve, reject) {
		// 		self.getStarredLocations().then(function(locations) {
		// 			self.locations = []

		// 			for (let i = 0; i < locations.length; i++) {
		// 				self.addLocation(locations[i].id, locations[i].directory, true)
		// 			}

		// 			resolve()
		// 		})
		// 	})
		// },
		pickNewLocation() {
			const self = this
			OC.dialogs.filepicker('Select a new Upload Folder', function(path) {
				// console.log(path)
				// console.log(this.currentFolderName)
				console.log('the path')
				console.log(path)

				self.addLocation(path + '/')
				setTimeout(function() {
					self.switchActiveLocationByPath(path + '/')
				}, 500)
			}, false, 'httpd/unix-directory', true, OC.dialogs.FILEPICKER_TYPE_CHOOSE)
		},
		getLocationByPath(path) {
			for (let i = 0; i < this.locations.length; i++) {
				if (this.locations[i].path === path) {
					// console.log(this.locations[i])
					return this.locations[i]
				}
			}
			return false
		},
		getLocationById(id) {
			for (let i = 0; i < this.locations.length; i++) {
				if (this.locations[i].id === id) {
					return this.locations[i]
				}
			}
			return false
		},
		addLocation(path) {
			// console.log(this.currentFolderName)
		    if (!this.getLocationByPath(path)) {
				const newFlow = new Flow({
					query(flowFile, flowChunk) {
						return {
							target: path,
						}
					},
					target: this.baseUrl + '/upload',
					permanentErrors: [403, 404, 500, 501],
					maxChunkRetries: 2,
					chunkRetryInterval: 5000,
					simultaneousUploads: 4,
				})

				this.locations.push({
					path,
					flow: newFlow,
				})
				console.log(this.locations)
			}
		},
		starLocation(path) {
			const location = this.getLocationByPath(path)

			// contentType: "application/json",

			axios.post(this.baseUrl + '/directories', {
				path,
			})
				.then(function(response) {
					location.id = response.id
				})
		},
		unstarLocationById(id) {
			const location = this.getLocationById(id)

			axios.delete(this.baseUrl + '/directories/' + id)
				.then(function(response) {
					location.id = false
				})
		},
		unstarLocationByPath(path) {
			const location = this.getLocationByPath(path)
			this.unstarLocationById(location.id)
		},

		removeLocation(path) {

			if (this.activeLocation.path === path) {
				this.activeLocationPath = false
			}

			this.locations = this.locations.filter(function(value, index, arr) {
				return value.path !== path
			})
		},
		trimDecimals(number, decimals = 2) {
			return number.toFixed(decimals)
		},
		bytes(bytes, precision) {
			if (isNaN(parseFloat(bytes)) || bytes === 0 || !isFinite(bytes)) return '-'
			if (typeof precision === 'undefined') precision = 1
			const units = ['bytes', 'kB', 'MB', 'GB']
			const number = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1)
			return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number]
		},
		byterate(bytes, precision) {
			if (isNaN(parseFloat(bytes)) || bytes === 0 || !isFinite(bytes)) return '0 KB/s'
			if (typeof precision === 'undefined') precision = 1
			const units = ['B/s', 'KB/s', 'MB/s', 'GB/s']
			const number = Math.min(Math.floor(Math.log(bytes) / Math.log(1000)), units.length - 1)
			return (bytes / Math.pow(1000, Math.floor(number))).toFixed(precision) + ' ' + units[number]
		},
		seconds(seconds, precision) {
			if (isNaN(parseFloat(seconds)) || seconds === 0 || !isFinite(seconds)) return '-'
			if (typeof precision === 'undefined') precision = 1
			const units = ['s', 'm', 'h']
			const number = Math.min(Math.floor(Math.log(seconds) / Math.log(60)), units.length - 1)
			return (seconds / Math.pow(60, Math.floor(number))).toFixed(precision) + ' ' + units[number]
		},
		addListenerMulti(element, eventNames, listener) {
			const events = eventNames.split(' ')
			for (let i = 0, iLen = events.length; i < iLen; i++) {
				element.addEventListener(events[i], listener, false)
			}
		},
		completedChunks(file) {
			let completeChunks = 0

			file.chunks.forEach(function(c) {
				if (c.progress() === 1) {
					completeChunks++
				}
			})

			console.log(completeChunks)

			return completeChunks
		},
		openLocationInFiles(path) {
			window.open('/index.php/apps/files/?dir=' + path, '_blank')
		},
		selectSortingMethod(sortMethod) {
			if (this.sort === sortMethod) {
				this.sortReverse = !this.sortReverse
			} else {
				this.sort = sortMethod
				this.sortReverse = false
			}
		},
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
				this.addLocation(`/${this.currentFolderName}/`)
				this.switchActiveLocationByPath(`/${this.currentFolderName}/`)

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

				// if (this.recentlyUploadedFileName !== '') {

					// console.log('CIA nodes and notes array !!!')
					// console.log(this.nodesAndNotes)
					// console.log(`CIA paskutinio ikelto failo vardas.. . . !!! ${this.recentlyUploadedFileName}`)

					// for (let index = 0; index < this.filteredFiles.length; index++) {

					// 	console.log(this.filteredFiles[index].isComplete())
					// }
					// this.recentlyUploadedFileName = ''
				// }

			} catch (e) {
				console.error(e)
				showError(t('notestutorial', 'Could not fetch notes'))
			}
			this.loading = false
		},

		/**
		 * toggle file upload menu
		 *
		 *
		 */
		toggleFileUploadMenu() {
			this.showFileUploadMenu = !this.showFileUploadMenu
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
				// console.log(this.isNavigationOpen)
			} else {
				this.isNavigationOpen = true
				// console.log(this.isNavigationOpen)
			}
		},
		/*
		 *
		 * handle time change
		 *
		 *
		 */
		handleDateChange() {
			// console.log(this.dateAndTime)
			const timestamp = new Date(this.dateAndTime).valueOf()
			// console.log(timestamp)
			// console.log(new Date(timestamp))
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
