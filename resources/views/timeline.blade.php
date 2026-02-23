<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roman History Timeline</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { 'roman-red': '#8B0000', 'roman-gold': '#D4AF37', 'roman-bg': '#F9F6EE' } }
            }
        }
    </script>
</head>
<body class="bg-roman-bg text-gray-800 antialiased">

    <header class="bg-roman-red text-roman-gold text-center py-10 border-b-4 border-roman-gold">
        <h1 class="text-3xl md:text-5xl font-serif font-bold tracking-widest uppercase mb-2">SPQR</h1>
        <h2 class="text-xl md:text-2xl font-serif mb-2 text-white">Roman History Archive</h2>
        <button onclick="openAddEventModal()" class="mt-4 bg-roman-gold text-roman-red px-6 py-2 rounded-lg font-bold hover:bg-yellow-400 transition-colors">
            + Add New Event
        </button>
    </header>

    <!-- Search Bar Section -->
    <div class="bg-white border-b-2 border-roman-gold shadow-md">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-roman-red text-xl">🔍</span>
                </div>
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Search events by title, location, key figures, or description..." 
                    class="w-full pl-10 pr-4 py-3 border-2 border-roman-gold rounded-lg focus:outline-none focus:border-roman-red focus:ring-2 focus:ring-roman-red/20 text-gray-800 placeholder-gray-500 font-serif"
                    onkeyup="searchEvents()"
                >
                <div id="searchResults" class="mt-2 text-sm text-roman-red font-semibold"></div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-12 px-4 relative">
        <div class="absolute left-[34px] md:left-[44px] top-12 bottom-12 w-1 bg-roman-red rounded"></div>
        
        <div id="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-roman-red"></div>
            <p class="mt-2 text-gray-600">Loading timeline data...</p>
        </div>
        
        <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline" id="error-text"></span>
        </div>
        
        <div id="timeline-container" class="relative hidden">
            <!-- Timeline events will be dynamically inserted here -->
        </div>
    </div>

    <!-- Roman-themed Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 pointer-events-none">
        <!-- Notifications will be dynamically inserted here -->
    </div>

    <!-- Add/Edit Event Modal -->
    <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h2 id="modalTitle" class="text-xl font-bold mb-4 text-roman-red">Add New Event</h2>
            <form id="eventForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Start Year</label>
                    <input type="number" id="start_year" name="start_year" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">End Year (optional)</label>
                    <input type="number" id="end_year" name="end_year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                    <input type="text" id="location" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Key Figures</label>
                    <input type="text" id="key_figures" name="key_figures" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea id="description" name="description" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red"></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Era</label>
                    <select id="era_id" name="era_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-roman-red">
                        <option value="">Select Era</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEventModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-roman-red text-white rounded-lg hover:bg-red-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm mx-4">
            <h2 class="text-xl font-bold mb-4 text-roman-red">Confirm Delete</h2>
            <p class="mb-6">Are you sure you want to delete this event? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <button onclick="deleteEvent()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // API endpoint configuration
        const API_BASE_URL = '/api';
        let currentEditingEventId = null;
        let currentDeletingEventId = null;
        let allEvents = []; // Store all events for search functionality
        
        // Get CSRF token
        function getCSRFToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            return token ? token.getAttribute('content') : '';
        }
        
        // Common headers for API requests
        function getAPIHeaders() {
            return {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            };
        }
        
        // Search functionality
        function searchEvents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const searchResults = document.getElementById('searchResults');
            
            if (searchTerm === '') {
                renderTimeline(allEvents);
                searchResults.textContent = '';
                return;
            }
            
            const filteredEvents = allEvents.filter(event => {
                const title = event.title.toLowerCase();
                const location = (event.location || '').toLowerCase();
                const keyFigures = (event.key_figures || '').toLowerCase();
                const description = event.description.toLowerCase();
                const eraName = (event.era ? event.era.name : '').toLowerCase();
                const year = event.start_year.toString();
                
                return title.includes(searchTerm) || 
                       location.includes(searchTerm) || 
                       keyFigures.includes(searchTerm) || 
                       description.includes(searchTerm) || 
                       eraName.includes(searchTerm) ||
                       year.includes(searchTerm);
            });
            
            renderTimeline(filteredEvents);
            
            // Show search results count
            const resultText = filteredEvents.length === 0 
                ? 'No events found matching your search' 
                : `Found ${filteredEvents.length} event${filteredEvents.length !== 1 ? 's' : ''} matching "${searchTerm}"`;
            searchResults.textContent = resultText;
        }
        
        // Clear search
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            document.getElementById('searchResults').textContent = '';
            renderTimeline(allEvents);
        }
        
        // Roman-themed notification system
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            const isRomanTheme = type === 'success' ? 'bg-roman-gold text-roman-red' : 'bg-roman-red text-roman-gold';
            const icon = type === 'success' ? '🏛️' : '⚔️';
            const borderTheme = type === 'success' ? 'border-roman-red' : 'border-roman-gold';
            
            notification.className = `${isRomanTheme} px-6 py-4 rounded-lg shadow-2xl border-2 ${borderTheme} mb-3 pointer-events-auto transform translate-x-full transition-all duration-500 ease-out`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <span class="text-2xl mr-3">${icon}</span>
                    <div>
                        <div class="font-bold text-lg">${type === 'success' ? 'Victory!' : 'Battle Lost!'}</div>
                        <div class="text-sm">${message}</div>
                    </div>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.classList.add('translate-x-0');
            }, 100);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                notification.classList.remove('translate-x-0');
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 500);
            }, 4000);
        }
        
        // Fetch eras from API
        async function fetchEras() {
            try {
                const response = await fetch(`${API_BASE_URL}/eras`, {
                    headers: getAPIHeaders()
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Failed to fetch eras');
                }
                
                return result.data;
            } catch (error) {
                console.error('Error fetching eras:', error);
                throw error;
            }
        }
        
        // Load eras into select dropdown
        async function loadEras() {
            try {
                const eras = await fetchEras();
                const eraSelect = document.getElementById('era_id');
                eraSelect.innerHTML = '<option value="">Select Era</option>';
                
                eras.forEach(era => {
                    const option = document.createElement('option');
                    option.value = era.id;
                    option.textContent = era.name;
                    eraSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading eras:', error);
            }
        }
        
        // Open add event modal
        function openAddEventModal() {
            currentEditingEventId = null;
            document.getElementById('modalTitle').textContent = 'Add New Event';
            document.getElementById('eventForm').reset();
            loadEras();
            document.getElementById('eventModal').classList.remove('hidden');
        }
        
        // Open edit event modal
        async function openEditEventModal(eventId) {
            currentEditingEventId = eventId;
            document.getElementById('modalTitle').textContent = 'Edit Event';
            
            try {
                const response = await fetch(`${API_BASE_URL}/events/${eventId}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Failed to fetch event');
                }
                
                const event = result.data;
                
                // Load eras first
                await loadEras();
                
                // Fill form with event data
                document.getElementById('title').value = event.title;
                document.getElementById('start_year').value = event.start_year;
                document.getElementById('end_year').value = event.end_year || '';
                document.getElementById('location').value = event.location || '';
                document.getElementById('key_figures').value = event.key_figures || '';
                document.getElementById('description').value = event.description;
                document.getElementById('era_id').value = event.era_id;
                
                document.getElementById('eventModal').classList.remove('hidden');
                
            } catch (error) {
                showError(`Failed to load event data: ${error.message}`);
            }
        }
        
        // Close event modal
        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
            document.getElementById('eventForm').reset();
            currentEditingEventId = null;
        }
        
        // Handle form submission
        document.getElementById('eventForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const eventData = {
                title: formData.get('title'),
                start_year: parseInt(formData.get('start_year')),
                end_year: formData.get('end_year') ? parseInt(formData.get('end_year')) : null,
                location: formData.get('location'),
                key_figures: formData.get('key_figures'),
                description: formData.get('description'),
                era_id: parseInt(formData.get('era_id'))
            };
            
            try {
                let response;
                if (currentEditingEventId) {
                    // Update existing event
                    response = await fetch(`${API_BASE_URL}/events/${currentEditingEventId}`, {
                        method: 'PUT',
                        headers: getAPIHeaders(),
                        body: JSON.stringify(eventData)
                    });
                } else {
                    // Create new event
                    response = await fetch(`${API_BASE_URL}/events`, {
                        method: 'POST',
                        headers: getAPIHeaders(),
                        body: JSON.stringify(eventData)
                    });
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Failed to save event');
                }
                
                closeEventModal();
                showNotification(currentEditingEventId ? 'Event updated successfully!' : 'New event added to the timeline!');
                initTimeline(); // Reload timeline
                
            } catch (error) {
                showNotification(`Failed to save event: ${error.message}`, 'error');
            }
        });
        
        // Confirm delete event
        function confirmDeleteEvent(eventId) {
            currentDeletingEventId = eventId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        // Close delete modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeletingEventId = null;
        }
        
        // Delete event
        async function deleteEvent() {
            if (!currentDeletingEventId) return;
            
            try {
                const response = await fetch(`${API_BASE_URL}/events/${currentDeletingEventId}`, {
                    method: 'DELETE',
                    headers: getAPIHeaders()
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Failed to delete event');
                }
                
                closeDeleteModal();
                showNotification('Event removed from the timeline!', 'success');
                initTimeline(); // Reload timeline
                
            } catch (error) {
                showNotification(`Failed to delete event: ${error.message}`, 'error');
            }
        }
        
        // Fetch events from API
        async function fetchEvents() {
            try {
                const response = await fetch(`${API_BASE_URL}/events`, {
                    headers: getAPIHeaders()
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Failed to fetch events');
                }
                
                return result.data;
            } catch (error) {
                console.error('Error fetching events:', error);
                throw error;
            }
        }
        
        // Render timeline events
        function renderTimeline(events) {
            const container = document.getElementById('timeline-container');
            container.innerHTML = '';
            
            events.forEach(event => {
                const eventElement = createEventElement(event);
                container.appendChild(eventElement);
            });
        }
        
        // Create individual event element
        function createEventElement(event) {
            const div = document.createElement('div');
            div.className = 'group relative bg-white rounded-xl shadow-md p-6 ml-12 md:ml-16 mb-8 border-l-4 border-roman-gold cursor-pointer';
            
            const eraName = event.era ? event.era.name : 'ไม่ระบุยุคสมัย';
            const startYear = event.start_year < 0 ? `${Math.abs(event.start_year)} BC` : `${event.start_year} AD`;
            const endYear = event.end_year ? 
                (event.end_year < 0 ? `${Math.abs(event.end_year)} BC` : `${event.end_year} AD`) : 
                'Ongoing';
            const yearRange = event.end_year ? `${startYear} - ${endYear}` : startYear;
            const location = event.location || 'ไม่ระบุ';
            const keyFigures = event.key_figures || 'ไม่ระบุ';
            
            // Store full description for toggle functionality
            const fullDescription = event.description;
            const abbreviatedDescription = fullDescription.length > 150 ? fullDescription.substring(0, 150) + '...' : fullDescription;
            let isExpanded = false;
            
            div.innerHTML = `
                <div class="absolute -left-[45px] md:-left-[55px] top-6 w-5 h-5 bg-roman-gold border-4 border-roman-red rounded-full z-10"></div>
                
                <div class="flex justify-between items-start mb-3">
                    <div class="inline-block bg-roman-red text-white text-xs px-2 py-1 rounded">
                        ${eraName}
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-0 translate-x-2">
                        <button onclick="openEditEventModal(${event.id})" class="bg-roman-gold text-roman-red px-3 py-1 rounded text-sm font-bold hover:bg-yellow-400 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg border border-roman-red">
                            Edit
                        </button>
                        <button onclick="confirmDeleteEvent(${event.id})" class="delete-cursor bg-roman-red text-roman-gold px-3 py-1 rounded text-sm font-bold hover:bg-red-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg border border-roman-gold">
                            Delete
                        </button>
                    </div>
                </div>
                
                <div class="font-bold text-roman-red text-2xl mb-1">
                    ${yearRange}
                </div>
                
                <h3 class="text-xl font-serif font-bold text-gray-800 mb-3">${event.title}</h3>
                
                <div class="text-gray-600 text-sm border-t pt-2 mt-2">
                    📍 สถานที่: ${location} <br>
                    👥 บุคคลสำคัญ: ${keyFigures} <br>
                    <div class="mt-2">
                        <span class="description-text">${abbreviatedDescription}</span>
                        ${fullDescription.length > 150 ? `
                            <button onclick="toggleDescription(${event.id}, this)" class="text-roman-red hover:text-red-700 font-semibold text-sm mt-1 ml-2 inline-block cursor-pointer">
                                <span class="toggle-text">📖 Show More</span>
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
            
            // Add click event to toggle description (excluding buttons)
            div.addEventListener('click', function(e) {
                // Don't toggle if clicking on buttons
                if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
                    return;
                }
                
                const descriptionText = div.querySelector('.description-text');
                const toggleButton = div.querySelector('button[onclick*="toggleDescription"]');
                const toggleText = div.querySelector('.toggle-text');
                
                if (fullDescription.length > 150) {
                    isExpanded = !isExpanded;
                    
                    if (isExpanded) {
                        descriptionText.textContent = fullDescription;
                        if (toggleText) toggleText.textContent = '📖 Show Less';
                    } else {
                        descriptionText.textContent = abbreviatedDescription;
                        if (toggleText) toggleText.textContent = '📖 Show More';
                    }
                }
            });
            
            return div;
        }
        
        // Toggle description function for button clicks
        function toggleDescription(eventId, button) {
            const eventDiv = button.closest('.group');
            const descriptionText = eventDiv.querySelector('.description-text');
            const toggleText = button.querySelector('.toggle-text');
            
            // Find the event data
            const event = allEvents.find(e => e.id === eventId);
            if (!event) return;
            
            const fullDescription = event.description;
            const abbreviatedDescription = fullDescription.length > 150 ? fullDescription.substring(0, 150) + '...' : fullDescription;
            
            if (descriptionText.textContent === abbreviatedDescription) {
                descriptionText.textContent = fullDescription;
                toggleText.textContent = '📖 Show Less';
            } else {
                descriptionText.textContent = abbreviatedDescription;
                toggleText.textContent = '📖 Show More';
            }
        }
        
        // Show error message
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const loadingDiv = document.getElementById('loading');
            const containerDiv = document.getElementById('timeline-container');
            
            errorText.textContent = message;
            errorDiv.classList.remove('hidden');
            loadingDiv.classList.add('hidden');
            containerDiv.classList.add('hidden');
        }
        
        // Initialize timeline
        async function initTimeline() {
            try {
                const events = await fetchEvents();
                allEvents = events; // Store all events for search functionality
                renderTimeline(events);
                
                // Hide loading and show timeline
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('timeline-container').classList.remove('hidden');
                
            } catch (error) {
                showError(`Failed to load timeline data: ${error.message}`);
            }
        }
        
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', initTimeline);
    </script>

</body>
</html>