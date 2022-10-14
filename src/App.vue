<template>
	<div id="content" class="app-dmsapp" @click="handleNavigationToggle()">
		<AppNavigation>
			<div v-if="isLogoHovered"
				class="selectCompanyPopup"
				:class="{
					marginLeft300: !isNavigationOpen,
				}">
				<div id="closeSelectCompanyPopup" @click="isLogoHovered=false">
					×
				</div>
				<div class="selectCompanyWrapper" @click="setSelectedCompany('Bankera')">
					<img class="selectCompanyLogo" src="../src/assets/images/bankera.svg">
					<p class="selectCompanyCompanyTitle">
						Bankera
					</p>
				</div>
				<div class="selectCompanyWrapper" @click="setSelectedCompany('SpectroCoin')">
					<img class="selectCompanyLogo" src="../src/assets/images/spectrocoin.svg">
					<p class="selectCompanyCompanyTitle">
						SpectroCoin
					</p>
				</div>
				<div class="selectCompanyWrapper" @click="setSelectedCompany('Pervesk')">
					<img class="selectCompanyLogo" src="../src/assets/images/pervesk.svg">
					<p class="selectCompanyCompanyTitle">
						Pervesk
					</p>
				</div>
			</div>

			<div class="selectedCompanyLogoContainer">
				<img v-if="selectedCompany === 'Bankera'" src="../src/assets/images/full-bankera.svg">
				<img v-if="selectedCompany === 'SpectroCoin'" src="../src/assets/images/full-spectrocoin.svg">
				<img v-if="selectedCompany === 'Pervesk'" src="../src/assets/images/full-pervesk.svg">
			</div>
			<div v-if="currentFolderName !== ''" class="filtersNavHeader " @click="showFiltersMenu = !showFiltersMenu">
				<span class="icon-filter fileIcon navigationIcon" />
				Filters <span class="filtersArrow">
					<img v-if="!showFiltersMenu" src="../src/assets/images/dropdown-icon.svg">
					<img v-if="showFiltersMenu" src="../src/assets/images/dropup-icon.svg">
				</span>
			</div>
			<div v-if="currentFolderName !== '' && showFiltersMenu" class="filtersContainer">
				<div v-for="filterName in filterNames[currentFolderName]" :key="filterName" class="form-group">
					<div class="col-auto toggleFiltersRow" @click="toggleFilter(filterName)">
						<label class="form-label text-large mr-2 pr-2">{{ filters[filterName].label.toUpperCase() }}</label>
						<img v-if="!filters[filterName].show" src="../src/assets/images/dropdown-icon.svg">
						<img v-if="filters[filterName].show" src="../src/assets/images/dropup-icon.svg">
					</div>
					<div v-if="filters[filterName].show">
						<div v-if="filterName !== 'form' && filterName !== 'inForceUntil' && filterName !== 'approvalDate' && filterName !== 'dateReceiptDate' && filterName !== 'lastRiskAssessmentDate' && filterName !== 'dateOfTheDocument' && filterName !== 'date' && filterName !== 'it' && filterName !== 'materiality' && filterName !== 'outsourcing' && filterName !== 'validSince' && filterName !== 'validUntil' && filterName !== 'form' && filterName !== 'it' && filterName !== 'materiality' && filterName !== 'outsourcing' && filterName !== 'documentStatus' && filterName !== 'validity' && filterName !== 'orderType' && filterName !== 'decisionType' && filterName !== 'deliveryMethod' && filterName !== 'direction' && filterName !== 'documentForm' && filterName !== 'documentType' && filterName !== 'validity' && filterName !== 'typePi' && filterName !== 'it'">
							<div class="col">
								<input v-model="filters[filterName].value" class="filterInput">
							</div>
						</div>
					</div>
					<div v-if="filters[filterName].show">
						<div v-if="filterName === 'form' || filterName === 'it' || filterName === 'materiality' || filterName === 'outsourcing' || filterName === 'documentStatus' || filterName === 'validity' || filterName === 'orderType' || filterName === 'decisionType' || filterName === 'deliveryMethod' || filterName === 'direction' || filterName === 'documentForm' || filterName === 'documentType' || filterName === 'validity' || filterName === 'typePi' || filterName === 'it'">
							<select v-model="filters[filterName].value"
								class="selectFilter">
								<option value="" selected>
									---Select---
								</option>
								<option v-for="option in dropdownSelections[filterName]"
									:key="option"
									:value="option">
									{{ option }}
								</option>
							</select>
						</div>
					</div>

					<div v-if="filters[filterName].show">
						<div v-if="filterName === 'date' || filterName === 'dateReceiptDate' || filterName === 'lastRiskAssessmentDate' || filterName === 'approvalDate' || filterName === 'inForceUntil'|| filterName === 'dateOfTheDocument' || filterName === 'validSince' || filterName === 'validUntil'" class="dateFilterContainer">
							<datetime v-model="filters[filterName].value.min"
								type="datetime"
								placeholder="Click to enter date"
								class="datetime" />
							<select v-model="filters[filterName].value.select" class="actionOptions">
								<option value="" selected>
									Action
								</option>
								<option value="on">
									On
								</option>
								<option value="before">
									Before
								</option>
								<option value="after">
									After
								</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="filesNavHeader">
				<span class="icon-files-dark fileIcon navigationIcon" />Files
			</div>
			<div v-for="navigationInfo in folderNames" :key="navigationInfo.endpoint" class="navigationContainer">
				<AppNavigationNew v-if="!loading"
					:text="t('dmsapp', `${navigationInfo.title}`)"
					:disabled="false"
					button-id="new-dmsapp-button"
					class="navigationFolderSelection"
					:class="{selectedFolder: currentFolderName === `${navigationInfo.folderName}`}"
					@click="
						loadNewFolder(`${navigationInfo.folderName}`, `${navigationInfo.endpoint}`)
					" />
			</div>
		</AppNavigation>
		<AppContent>
			<div>
				<h1 v-if="currentFolderName !== ''" class="folderName">
					{{ currentFolderName }}
				</h1>
				<!-- FILE UPLOADING COMPONENT -->
				<template v-if="currentFolderName !== ''">
					<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

					<div v-if="!loading"
						class="uploadFilesComponent"
						style="margin-left: 4%; margin-right: 4%; margin-top: 7px; width:auto">
						<div v-if="activeLocation === undefined" id="noLocationSelected">
							{{ t('dmsapp', 'Please select a location') }}
						</div>
						<div v-if="activeLocation != undefined" id="locationSelected">
							<label for="FileSelectInput">
								<div class="uploadButton">Upload file</div>
							</label>

							<input id="FileSelectInput"
								class="selectionInput"
								type="file"
								@change="filesSelected">
						</div>
						<p>
							<span v-if="activeLocationFilesCount != 0" class="label">{{ t('dmsapp', 'Progress') + ' : ' + trimDecimals(activeLocation.flow.progress()*100, 2) + '%' }}</span>
							<span v-if="activeLocation.flow.isUploading()" class="label">{{ t('dmsapp', 'Time remaining') + ' : ' + seconds(activeLocation.flow.timeRemaining()) }}</span>
							<span v-if="activeLocation.flow.isUploading()" class="label">{{ t('dmsapp', 'Uploading') + '...' }}</span>
						</p>
						<b-modal id="modal-2"
							ref="upload-modal"
							hide-footer
							no-close-on-esc
							no-close-on-backdrop
							hide-header-close>
							<p class="uploadModalMessage">
								Please wait ...
							</p>
							<div v-if="filteredFiles">
								<div v-for="(file) in filteredFiles" :key="'file-' + file.uniqueIdentifier">
									<p v-if="!file.isComplete() && !file.error" class="ellipsis" :title="'UID: ' + file.uniqueIdentifier">
										<span>Uploading {{ file.relativePath }}</span>
									</p>

									<p>
										<progress v-if="!file.isComplete() && !file.error"
											class="progressbar hideOnMobile"
											max="1"
											:value="file.progress()" />
										<span v-if="!file.isComplete() && !file.error">{{ trimDecimals(file.progress()*100, 2) }}%</span>
										<span v-if="file.isComplete() && !file.error">{{ t('dmsapp', 'Completed') }}</span>
										<i v-if="file.isComplete() && !file.error">{{ afterFileUpload }}</i>
									</p>
									<div v-if="file.error">
										<span>{{ t('dmsapp', 'Unexpected error') }}</span>
										<button class="reloadButton" @click="reloadPage">
											Reload page
										</button>
									</div>
								</div>
							</div>
						</b-modal>
					</div>
				</template>
				<!-- THE ACTIVE FILTERS THAT APPEAR ABOVE THE TABLE -->
				<div v-if="currentFolderName !== ''" class="activeFiltersAboveTable">
					<span class="activeFilters">Active filters:</span>
					<div v-for="filterName in filterNames[currentFolderName]" :key="filterName">
						<div v-if="filters[filterName].value !== '' && filters[filterName].value.min !== '' && filters[filterName].value.select !== ''" class="selectedFilterAboveTableContainer">
							<p v-if="!filters[filterName].value.min && !filters[filterName].value.select " class="selectedFilterAboveTable">
								{{ filters[filterName].label }}: <span class="selectedFilterAboveTableValue">{{ filters[filterName].value }}</span>

								<span class="removeOneFilter" @click="removeOneFilter(filterName)">×</span>
							</p>
							<p v-if="filters[filterName].value.select && filters[filterName].value.min" class="selectedFilterAboveTable">
								{{ filters[filterName].label }}: <span class="selectedFilterAboveTableValue">{{ `${filters[filterName].value.select} ${new Date(filters[filterName].value.min).toLocaleString("lt-LT")}` }}</span>
								<span class="removeOneFilter" @click="removeOneFilter(filterName)">×</span>
							</p>
						</div>
					</div>
					<span class="clearAllFilters" @click="removeMatchingFilters(currentFolderName)">Clear all</span>

					<b-modal id="modal-1"
						ref="info-modal"
						hide-footer
						:no-close-on-esc="recentlyUploadedFileName !== ''"
						:no-close-on-backdrop="recentlyUploadedFileName !== ''"
						:hide-header-close="recentlyUploadedFileName !== ''"
						title="Edit file information">
						<div v-if="currentNote" class="editPanel">
							<form>
								<div v-for="tableInfo in currentTableInfo" :key="tableInfo.key" :sort-key="tableInfo.key">
									<label>{{ `${tableInfo.header} :` }}</label>
									<input v-if="
											tableInfo.fieldType !== 'date' &&
												tableInfo.fieldType !== 'boolean' &&
												tableInfo.fieldType !== 'choice' &&
												tableInfo.fieldType !== 'number' &&
												tableInfo.key !== 'name'"
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
									<div v-if="tableInfo.key === 'name'">
										<p>{{ currentNote.name }}</p>
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
											<option v-for="option in dropdownSelections[tableInfo.key]" :key="option" :value="option">
												{{ option }}
											</option>
										</select>
									</div>
								</div>
								<input type="submit"
									class="primary"
									:value="t('dmsapp', 'Save')"
									:disabled="updating || savePossible"
									@click="saveNote">

								<input type="button"
									class="primary"
									:disabled="recentlyUploadedFileName !== ''"
									:value="t('dmsapp', 'Cancel')"
									@click="cancelNewNote(currentNote)">
							</form>
						</div>
					</b-modal>
				</div>

				<template>
					<div class="container">
						<v-table :data="nodesAndNotes"
							:filters="filters"
							:hide-sort-icons="true"
							:current-page.sync="currentPage"
							:page-size="paginationSize"
							class="my-2 table table-striped"
							selection-mode="single"
							selected-class="table-info"
							:class="{
								navigationOpen: isNavigationOpen,
								navigationClosed: !isNavigationOpen,
							}"
							@totalPagesChanged="totalPages = $event"
							@selectionChanged="selectedRows = $event">
							<thead slot="head" class="tableHead">
								<v-th v-for="tableInfo in currentTableInfo"
									:key="tableInfo.key"
									:hide-sort-icons="true"
									:sort-key="tableInfo.key"
									class="tableHeadOptions tableBorder">
									<div class="tableHeadTextContainer">
										<b>{{ tableInfo.header }}</b>
										<!-- POPUP FILTERS IN TABLE HEADER -->
										<div v-for="filterName in filterNames[currentFolderName]" :key="filterName">
											<div class="has-inlineFiltersDetails">
												<span v-if="tableInfo.key === filterName" class="icon-filter fileIcon navigationIcon " />
												<span class="inlineFiltersDetails">

													<div v-if="filterName !== 'form' && filterName !== 'approvalDate' && filterName !== 'dateReceiptDate' && filterName !== 'lastRiskAssessmentDate' && filterName !== 'inForceUntil' && filterName !== 'dateOfTheDocument' && filterName !== 'date' && filterName !== 'it' && filterName !== 'materiality' && filterName !== 'outsourcing' && filterName !== 'validSince' && filterName !== 'validUntil' && filterName !== 'form' && filterName !== 'it' && filterName !== 'materiality' && filterName !== 'outsourcing' && filterName !== 'documentStatus' && filterName !== 'validity' && filterName !== 'orderType' && filterName !== 'decisionType' && filterName !== 'deliveryMethod' && filterName !== 'direction' && filterName !== 'documentForm' && filterName !== 'documentType' && filterName !== 'validity' && filterName !== 'typePi' && filterName !== 'it'">
														<div class="col">
															<input v-model="filters[filterName].value" class="filterInput">
														</div>
													</div>
													<div v-if="filterName === 'form' || filterName === 'it' || filterName === 'materiality' || filterName === 'outsourcing' || filterName === 'documentStatus' || filterName === 'validity' || filterName === 'orderType' || filterName === 'decisionType' || filterName === 'deliveryMethod' || filterName === 'direction' || filterName === 'documentForm' || filterName === 'documentType' || filterName === 'validity' || filterName === 'typePi' || filterName === 'it'">
														<select v-model="filters[filterName].value"
															class="selectFilter">
															<option value="" selected>
																---Select---
															</option>
															<option v-for="option in dropdownSelections[filterName]"
																:key="option"
																:value="option">
																{{ option }}
															</option>
														</select>
													</div>
													<div v-if="filterName === 'date' || filterName === 'dateReceiptDate' || filterName === 'lastRiskAssessmentDate' || filterName === 'approvalDate' || filterName === 'dateOfTheDocument' || filterName === 'validSince' || filterName === 'validUntil' || filterName === 'inForceUntil'" class="dateFilterContainer">
														<datetime v-model="filters[filterName].value.min"
															type="datetime"
															placeholder="Click to enter date"
															class="datetime" />
														<select v-model="filters[filterName].value.select" class="actionOptions">
															<option value="" selected>
																Action
															</option>
															<option value="on">
																On
															</option>
															<option value="before">
																Before
															</option>
															<option value="after">
																After
															</option>
														</select>
													</div>

												</span>
											</div>
										</div>
									</div>
								</v-th>
							</thead>
							<tbody slot="body" slot-scope="{ displayData }">
								<v-tr v-for="row in displayData" :key="row.id" :row="row">
									<td v-for="rowInfo in currentTableInfo" :key="rowInfo.key" class="tableBorder">
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
											:value="t('dmsapp', 'Edit')"
											@click="openEdit(row)">
									</td>

									<td>
										<input type="button"
											class="primary"
											:value="t('dmsapp', 'Open')"
											@click="openFile(row.idfile, row.path)">
									</td>
								</v-tr>
							</tbody>
						</v-table>
						<div v-if="currentFolderName !== '' " class="paginationContainer">
							<smart-pagination :hide-single-page="false"
								:current-page.sync="currentPage"
								:total-pages="totalPages" />
							<select v-model="paginationSize" class="paginationSelect">
								<option :value="10">
									10
								</option>
								<option :value="25">
									25
								</option>
								<option :value="50">
									50
								</option>
							</select>
						</div>
					</div>
					<div v-if="currentFolderName === ''" id="emptycontent">
						<div v-if="selectedCompany === 'Bankera'">
							<img src="../src/assets/images/bankera-folder.svg">
							<h3>Welcome to Bankera documents</h3>
							<p>Select folder on left side to start</p>
						</div>
						<div v-if="selectedCompany === 'SpectroCoin'">
							<img src="../src/assets/images/spectrocoin-folder.svg">
							<h3>Welcome to SpectroCoin documents</h3>
							<p>Select folder on left side to start</p>
						</div>
						<div v-if="selectedCompany === 'Pervesk'">
							<img src="../src/assets/images/pervesk-folder.svg">
							<h3>Welcome to Pervesk documents</h3>
							<p>Select folder on left side to start</p>
						</div>
					</div>
				</template>
			</div>
		</Appcontent>
		<div v-if="currentFolderName === '' && selectedCompany === ''" id="emptycontent">
			<!-- START SCREEN -->
			<template>
				<div class="startScreenBackground">
					<div class="startScreenContainer">
						<p class="startScreenTitle">
							Select company to view documents:
						</p>
						<div class="startScreenLogosContainer" @click="setSelectedCompany('Bankera')">
							<div class="startScreenLogoCover">
								<img class="startScreenBankeraLogo" src="../src/assets/images/bankera.svg">
								<p class="startScreenCompanyTitle">
									Bankera
								</p>
							</div>
							<div class="startScreenLogoCover" @click="setSelectedCompany('SpectroCoin')">
								<img src="../src/assets/images/spectrocoin.svg">
								<p class="startScreenCompanyTitle">
									SpectroCoin
								</p>
							</div>
							<div class="startScreenLogoCover" @click="setSelectedCompany('Pervesk')">
								<img class="startScreenPerveskLogo" src="../src/assets/images/pervesk.svg">
								<p class="startScreenCompanyTitle">
									Pervesk
								</p>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
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
import tableInfo from './table/tableInfo.json'
import dropdownSelections from './table/dropdownSelections.json'
import filterNames from './table/filterNames.json'
import folderNames from './table/folderNames.json'

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

	data: () => ({
		currentPage: 1,
		totalPages: 0,
		paginationSize: 25,
		fileIsBeingUploaded: false,
		selectedCompany: '',
		name: 'Selection',
		selectedRows: [],
		notes: [],
		nodes: [],
		nodesAndNotes: [],
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
		baseUrl: generateUrl('/apps/dmsapp'),
		activeLocationPath: false,
		sort: 'name',
		sortReverse: false,
		search: '',
		recentlyUploadedFileName: '',
		dropdownSelections,
		filterNames,
		folderNames,
		showFiltersMenu: false,
		isLogoHovered: false,
		activeFiltersAboveTable: 0,

		filters: {

			date: {
				show: false,
				label: 'Date',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.date)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},
			},
			lastRiskAssessmentDate: {
				show: false,
				label: 'Last Risk Assessment Date',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.lastRiskAssessmentDate)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},
			},
			materiality: {
				value: '',
				keys: ['materiality'],
				show: false,
				label: 'Materiality',

			},
			decisionType: {
				value: '',
				keys: ['decisionType'],
				show: false,
				label: 'Decision type',
			},
			deliveryMethod: {
				value: '',
				keys: ['deliveryMethod'],
				show: false,
				label: 'Delivery method',
			},
			direction: {
				value: '',
				keys: ['direction'],
				show: false,
				label: 'Direction',
			},
			documentForm: {
				value: '',
				keys: ['documentForm'],
				show: false,
				label: 'Document form',
			},
			documentOrganizer: {
				value: '',
				keys: ['documentOrganizer'],
				show: false,
				label: 'Document organizer',
			},
			documentType: {
				value: '',
				keys: ['documentType'],
				show: false,
				label: 'Document type',
			},
			form: {
				value: '',
				keys: ['form'],
				show: false,
				label: 'Form',
			},
			it: {
				value: '',
				keys: ['it'],
				show: false,
				label: 'IT',
			},
			participants: {
				value: '',
				keys: ['participants'],
				show: false,
				label: 'Participants',
			},
			personalOwner: {
				value: '',
				keys: ['personalOwner'],
				show: false,
				label: 'Personal owner',
			},
			recipientEmployee: {
				value: '',
				keys: ['recipientEmployee'],
				show: false,
				label: 'Recipient employee',
			},
			typePi: {
				value: '',
				keys: ['typePi'],
				show: false,
				label: 'Type Pi',
			},
			createdBy: {
				value: '',
				keys: ['userId'],
				show: false,
				label: 'Created by',
			},
			outsourcing: {
				value: '',
				keys: ['outsourcing'],
				show: false,
				label: 'Outsourcing',

			},
			validity: {
				value: '',
				keys: ['validity'],
				show: false,
				label: 'Validity',

			},
			description: {
				value: '',
				keys: ['description'],
				show: false,
				label: 'Description',

			},
			documentStatus: {
				value: '',
				keys: ['documentStatus'],
				show: false,
				label: 'Document Status',

			},
			orderType: {
				value: '',
				keys: ['orderType'],
				show: false,
				label: 'Order Type',

			},
			validSince: {

				show: false,
				label: 'Valid Since',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.validSince)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},

			},
			validUntil: {
				show: false,
				label: 'Valid Until',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.validUntil)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},

			},
			dateOfTheDocument: {
				show: false,
				label: 'Date (date of the document)',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.dateOfTheDocument)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},
			},
			dateReceiptDate: {
				show: false,
				label: 'Date (receipt date)',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.dateReceiptDate)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},
			},
			approvalDate: {
				show: false,
				label: 'Approval date',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.approvalDate)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},
			},
			inForceUntil: {
				show: false,
				label: 'In force until (date)',
				value: { min: '', select: '' },
				custom: function date(filterValue, row) {
					if (filterValue.min !== '') {
						const currentDate = Date.parse(row.inForceUntil)
						const userDate = Date.parse(filterValue.min)
						if (filterValue.select === 'before') {
							return currentDate < userDate
						}
						if (filterValue.select === 'after') {
							return currentDate > userDate
						}
						if (filterValue.select === 'on') {
							return currentDate === userDate
						}

					}
					return true
				},

			},

		},

	}),

	computed: {
		activeLocation() {
			if (this.activeLocationPath) {
				// console.log('activeLocationPath')
				// console.log(this.activeLocationPath)
				return this.getLocationByPath(this.activeLocationPath)
			} else {
				return undefined
			}
		},
		filteredFiles() {
			if (this.activeLocation.flow) {
				let sorted

				sorted = [...this.activeLocation.flow.files]

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
			// console.log(this.filteredFiles[0].name)
			this.recentlyUploadedFileName = this.filteredFiles[0].name
			this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
			setTimeout(() => {
				// console.log('Delayed for 1 second.')
				this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
				// console.log(this.$refs)
			}, '1000')

			setTimeout(() => {
				// console.log('Delayed for 3 second.')
				this.$refs[this.recentlyUploadedFileName][0].click()
				this.fileIsBeingUploaded = false
				this.hideUploadModal()
			}, '3000')
			this.activeLocation.flow.cancel()

			return null
		},
	},
	/**
	 * change loading state after loaded
	 */
	async mounted() {
		const element = document.querySelector('[aria-label="DMS app"]')
		element.classList.add('dmsapplogo')

		element.addEventListener('mouseenter', (event) => {
			this.isLogoHovered = true
		}, false)

		this.loading = false
	},

	methods: {

		setSelectedCompany(companyName) {
			this.selectedCompany = companyName
			if (this.currentFolderName !== '') {
				this.loadOnCompanyChange()
			}
		},
		toggleFilter(filterName) {
			this.filters[filterName].show = !this.filters[filterName].show
			// console.log(this.filters[filterName].show)
		},
		loadOnCompanyChange() {
			this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
		},
		reloadPage() {
			window.location.reload()
		},
		removeMatchingFilters(folderName) {
			const filtersForThisFolder = this.filterNames[folderName]
			for (let index = 0; index < filtersForThisFolder.length; index++) {
				const filterInfo = this.filters[filtersForThisFolder[index]]
				if (typeof filterInfo.value === 'object') {
					filterInfo.value.min = ''
					filterInfo.value.select = ''
				}
				if (typeof filterInfo.value === 'string') {
					filterInfo.value = ''
				}
			}
		},
		removeOneFilter(filterToRemove) {
			const filterInfo = this.filters[filterToRemove]
			if (typeof filterInfo.value === 'object') {
				filterInfo.value.min = ''
				filterInfo.value.select = ''
			}
			if (typeof filterInfo.value === 'string') {
				filterInfo.value = ''
			}
		},
		filesSelected(event) {
			this.activeLocation.flow.addFiles(event.target.files)
			document.querySelectorAll('#FileSelectInput, #FolderSelectInput').value = null
			this.fileIsBeingUploaded = true
			this.showUploadModal()
			this.activeLocation.flow.resume()
		},

		switchActiveLocationByPath(path) {
			this.activeLocationPath = path
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
		addLocation(path) {
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
			}
		},
		trimDecimals(number, decimals = 2) {
			return number.toFixed(decimals)
		},
		seconds(seconds, precision) {
			if (isNaN(parseFloat(seconds)) || seconds === 0 || !isFinite(seconds)) return '-'
			if (typeof precision === 'undefined') precision = 1
			const units = ['s', 'm', 'h']
			const number = Math.min(Math.floor(Math.log(seconds) / Math.log(60)), units.length - 1)
			return (seconds / Math.pow(60, Math.floor(number))).toFixed(precision) + ' ' + units[number]
		},
		showModal() {
			this.$refs['info-modal'].show()
		},
		hideModal() {
			this.$refs['info-modal'].hide()
		},
		showUploadModal() {
			this.$refs['upload-modal'].show()
		},
		hideUploadModal() {
			this.$refs['upload-modal'].hide()
		},
		async loadNewFolder(folderName, endpointName) {
			try {
				// console.log(this.folderNames)
				const response = await axios.get(
					generateUrl(`/apps/dmsapp/${endpointName}`)
				)
				this.notes = response.data
				const nodesResponse = await axios.get(
					generateUrl(`/apps/dmsapp/nodelist/.System_DMS_Shares/${this.selectedCompany}/${folderName}`)
				)
				// console.log(`/apps/dmsapp/nodelist/${this.selectedCompany}/${folderName}`)
				this.nodes = nodesResponse.data
				this.currentEndpoint = endpointName
				this.currentTableInfo = tableInfo[folderName]
				this.currentFolderName = folderName

				const notesIds = []
				const nodesIds = []
				this.addLocation(`/.System_DMS_Shares/${this.selectedCompany}/${this.currentFolderName}/`)
				this.switchActiveLocationByPath(`/.System_DMS_Shares/${this.selectedCompany}/${this.currentFolderName}/`)

				for (let index = 0; index < this.nodes.length; index++) {
					const element = this.nodes[index]
					nodesIds.push(element.id)
				}
				for (let index = 0; index < this.notes.length; index++) {
					const element = this.notes[index]
					notesIds.push(element.idfile)
				}
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
							idfile: JSON.stringify(currentObject.id),
							title: 'N/A',
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
							auditDate: 'N/A',
							partiesRelated: 'N/A',
							natureOfFunction: 'N/A',
							lastRiskAssessmentResult: 'N/A',
							basisForMateriality: 'N/A',
							locationOfData: 'N/A',
							locationOfServices: 'N/A',
							transferOfData: 'N/A',
							bankLtApprovalDate: 'N/A',
							bankLtNotifDate: 'N/A',
							relatedToPervesk: 'N/A',
							agreementApprovedBy: 'N/A',
							governingLawOfTheAgreement: 'N/A',
							subcontractors: 'N/A',
							serviceProviderAddress: 'N/A',
							providerEntCode: 'N/A',
							serviceProviderName: 'N/A',
							providerPrntCompany: 'N/A',
							providerResult: 'N/A',
							alternativeServiceProviders: 'N/A',
							fnSupCritical: 'N/A',
							priceOfAgreement: 'N/A',
							outsrcdFnNotProvided: 'N/A',
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
							company: this.selectedCompany,
						},
						endpointName
					)
				}

				this.nodesAndNotes = this.nodes.map((t1) => ({
					...t1,
					...this.notes.find((t2) => Number(t2.idfile) === t1.id),
				}))
				// console.log(this.nodesAndNotes)
				// this
				this.removeMatchingFilters(folderName)

			} catch (e) {
				console.error(e)
				showError(t('dmsapp', `Could not fetch! Make sure that folder named '${folderName}' exists`))
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
				// console.log(this.isNavigationOpen)
			} else {
				this.isNavigationOpen = true
				// console.log(this.isNavigationOpen)
			}
		},

		/**
		 * open the clicked file
		 *
		 *@param {string} fileId ID of file you wish to open
		 *
		 */
		openFile(fileId) {
			const host = new URL(window.location.href).origin
			const redirectTo = `${host}/index.php/f/${fileId}`
			window.open(redirectTo)
		},
		/**
		 * open Editing menu for a row
		 *
		 * @param {object} row Note object
		 */
		openEdit(row) {
			this.currentNoteId = row.id
			this.showModal()
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new note or save
		 */
		saveNote() {
			this.hideModal()
			this.recentlyUploadedFileName = ''
			if (this.currentNoteId === -1) {
				this.createNote(this.currentNote)
			} else {
				this.updateNote(this.currentNote, this.currentEndpoint)
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
				const response = await axios.post(
					generateUrl(`/apps/dmsapp/${endpointName}`),
					note
				)
				const index = this.notes.findIndex(
					(match) => match.id === this.currentNoteId
				)
				this.$set(this.notes, index, response.data)
				this.currentNoteId = response.data.id
			} catch (e) {
				console.error(e)
				showError(t('dmsapp', 'Could not create the note'))
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
					generateUrl(`/apps/dmsapp/${endpointName}/${note.id}`),
					note
				)
				// loadNewFolder here works like page reload after info update, because the information showed in the table is taken from Database.
				this.loadNewFolder(this.currentFolderName, this.currentEndpoint)
			} catch (e) {
				console.error(e)
				showError(t('dmsapp', 'Could not update the note'))
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
				await axios.delete(generateUrl(`/apps/dmsapp/notes/${note.id}`))
				this.notes.splice(this.notes.indexOf(note), 1)
				if (this.currentNoteId === note.id) {
					this.currentNoteId = null
				}
				showSuccess(t('dmsapp', 'Note deleted'))
			} catch (e) {
				console.error(e)
				showError(t('dmsapp', 'Could not delete the note'))
			}
		},
	},
}
</script>
<style>
.vdatetime-overlay{
	z-index: 1500!important;
}
.vdatetime-popup{
	z-index: 1501!important;
}
	.navigationContainer{
		padding: 0;
		z-index: 1049!important;
	}

	.navigationContainer>.navigationFolderSelection>button{
	border: none;
    background-color: white;
    border-radius: 0;
	font-weight: 400;
	font-size: 14px;

}
.navigationContainer>.navigationFolderSelection>button:active{
	color: #00aeff!important;
}
.navigationContainer>.navigationFolderSelection>button:hover{
	color: #70a9ff
}

.selectedFolder{
	border-left: solid 5px #0d6efd;
}
.selectedFolder>button{
	color: #0d6efd
}

#header{
	z-index: 1050!important;
}

#modal-2___BV_modal_content_{
	margin-top: 100px;
	background-color: transparent;
	border: none!important;
	position: absolute;
	padding-top: 50%;
	left: 20%;
	color: white;
	font-size: xx-large;
}
#modal-2___BV_modal_header_{
border-bottom: none!important
}
#new-dmsapp-button{
	padding: 0 0 0 30px;
}
.datetime>input{
		color: grey;
		font-size: 14px;
    font-weight: 300;
	}
</style>
<style scoped>
.uploadButton{
	background-color: #1940B8;
    color: white;
    padding: 6px 21px;
    font-weight: 500;
    border-radius: 19px;
}
	.uploadButton:hover{
	background-color: #6aa5ff;
	cursor: pointer;
}
.uploadButton:active{
	background-color: #2a7fff;
	color: #ffffff;
	cursor: pointer;
}
.selectedFolder:active{
	border-left: solid 5px #0d6efd;
	color: #0d6efd;
}
	.progressbar{
		width: 100%;
		height: 50px;
	}
	.reloadButton{
	border-radius: 2px;
    margin-left: 20px;
    color: white;
    background: #00b6ff85;
    padding: 10px 50px;
    border: none;
}
#body-user #header, #body-settings #header, #body-public #header {
		z-index: 0;
	}
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
.tableBorder{
	border: solid #9d9d9d6e 1px;
}
.vt-sort:before{
    font-family: FontAwesome;
    padding-right: 0.5em;
    width: 1.28571429em;
    text-align: center;
	display: inline-flex;
	align-items: center;
}

.vt-sortable::before {
	content: "\25B2";
	color: transparent;
}

.vt-asc::before {
	content: "\25BC";
}

.vt-desc::before {
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
}

.editPanel {
	padding-top: 10px;
}

.filterInput {
	width: auto;
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
	background-color: #eee;;
	position: -webkit-sticky;
	padding-left: 310px;
	left: 0;
	position: sticky;
}

.navigationOpen th:first-child {
	background-color: #eee;;
	position: -webkit-sticky;
	padding-left: 310px;
	left: 0;
	position: sticky;
}

.navigationClosed td:first-child {
	background-color: #eee;;
	position: -webkit-sticky;
	left: 0;
	position: sticky;
}

.navigationClosed th:first-child {
	background-color: #eee;;
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
#title{
	text-align: center;
}
.selectionInput{
	display: none;
}
.selectionLabel{
	background-color: rgb(219, 232, 253);
	cursor: pointer;
	width: 100%;
	height: 100px;
}
.selectionLabel:hover{
	background-color: rgb(197, 219, 255);
	cursor: pointer;

}
.fileIcon{
transform: scale(3);
margin-top: 15px;
padding: 20px;
}
.buttonGroup{
	text-align: center;
}
#modal-1{
	margin-top: 100px;
}

#app-navigation-vue{
	z-index: 1050;
	height: max-content;
	height: 100vh;
}
.filtersContainer{
	flex-direction: column;
    width: max-content;
	padding-left: 10%;
}
.dateFilterContainer{
	display: flex;
    align-items: center;
}
.folderName{
	display: inline-flex;
	padding-top: 50px;
	margin-left: 34px;
    margin-bottom: 24px;
}
.selectFilter{
	width: 200px;
}
.navigationFolderSelection:hover{
    border-left: solid 5px #70a9ff;
}
.navigationFolderSelection{
	padding: 0;
}
.paginationContainer{
	display: flex;
	flex-direction: row;
}
.paginationSelect{
	margin-left: 30px;
}
.tableHeadOptions{
	z-index: 50;
	/* background-color: rgb(211, 211, 211); */
}
.tableHeadTextContainer{
	width: min-content;
	display: inline-flex;
	justify-content: center;
    align-items: center;
white-space: normal;
color: rgb(0, 0, 0);
	}
	.selectCompanyFilter{
		margin-left: 40px;
	}
	.navigationIcon{
		margin-left: 20px;
		cursor: pointer;
	}
	.filesNavHeader{
		margin: 20px 0 29px
	}
	.filtersNavHeader{
		cursor: pointer;
		margin: 23px 0 25px;
	}
	.toggleFiltersRow{
	display: flex;
    justify-content: space-between;
	font-weight: 400;
    font-size: 14px;
	width: 250px;
	cursor: pointer;
	}
	.toggleFiltersRow:hover{
		color: rgb(59, 59, 59) ;
	}
	.actionOptions{
		color: grey;
		font-size: 14px;
    font-weight: 300;
	}
.filtersArrow{
    margin-left: 157px;
}

.has-inlineFiltersDetails {
  position: relative;
}

.inlineFiltersDetails {
  position: absolute;
  top: -70px;
  left: 10px;
  transform: translateY(70%) scale(0);
  transition: transform 0.1s ease-in;
  transform-origin: left;
  display: inline;
  background: white;
  z-index: 20;
  min-width: 250px;
  padding: 2rem;
  border-radius: 5px;
  box-shadow: 10px 10px 20px grey;
}

.has-inlineFiltersDetails:hover span {
  transform: translateY(70%) scale(1);
}
.activeFiltersAboveTable{
margin-left: 50px;
display: flex;
align-items: center;
}
.selectedFilterAboveTable{
	color: white;
	background-color: #1941b88a;
	border-radius: 5px;
	padding: 0 15px;
	margin: 0;
}
.selectedFilterAboveTableContainer{
	margin: 0 7px 0 7px;
}
.selectedFilterAboveTableValue{
	font-weight: bold;
	margin: 0 5px 15px;
}
.removeOneFilter{
	font-weight: bold;
    font-size: 22px;
	cursor: pointer;
	transform: translate(-50%, -50%);

}
.removeOneFilter:hover{
	color: rgba(201, 201, 201, 0.164);
}

.startScreenContainer{
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.startScreenLogosContainer{
    display: flex;
    justify-content: center;
    align-items: center;
}
.startScreenBackground{
    position:fixed;
    padding:0;
    margin:0;

    top:0;
    left:0;
    z-index: 1300;
    width: 100%;
    height: 100%;
    background:#1940B8
}
.startScreenLogoCover{
	cursor: pointer;
    background-color: white;
    padding: 50px;
    border-radius: 16px;
    margin: 0 32px ;
}
.startScreenBankeraLogo{
	padding: 0 16px;
}
.startScreenPerveskLogo{
	padding: 0 16px;
}
.startScreenLogoCover>img{
	cursor: pointer;

}
.startScreenLogoCover:hover{
	box-shadow: 15px 15px 30px rgb(21, 46, 158);

}
.startScreenTitle{
    color: white;
    font-size: 32px;
}
.startScreenCompanyTitle{
	cursor: pointer;
    margin-top: 10px;
    font-size: 20px;
    color: black;
}
.selectedCompanyLogoContainer{
	margin: 20px 0 0 32px;

}
.clearAllFilters{
	font-weight: 600;
    font-size: 14px;
    color: #707070;
}
.clearAllFilters:hover{
    color: #ff2a2aa1;
	cursor: pointer;
}
.activeFilters{
	font-size: 14px;
	font-weight: 300;
}
.uploadFilesComponent{
	display: inline-flex;
}

.selectCompanyPopup{
    position: absolute;
    left: 300px;
    background-color: white;
    border-radius: 5px;
	box-shadow: 10px 10px 10px grey;

}
.selectCompanyWrapper{
	display: flex;
	padding: 0 20px;
}
.selectCompanyWrapper:hover{
	background-color: rgb(157, 163, 255);
	border-radius: 5px;
	cursor: pointer;
}
.selectCompanyCompanyTitle{
	display: flex;
	align-items: center;
	justify-content: center;
	margin: 0;
}
.selectCompanyLogo{
	transform: scale(0.4);
}
#closeSelectCompanyPopup{
	position: absolute;
    right: -36px;
    font-size: 30px;
    font-weight: bold;
    background-color: white;
    padding: 0 10px;
}
#closeSelectCompanyPopup:hover{
	background-color: rgb(255, 71, 71);
	color: white;
	cursor: pointer;
}
.marginLeft300{
	margin-left: 300px;
}
</style>
