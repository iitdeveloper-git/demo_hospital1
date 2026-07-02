<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $servicesData = [
            [
                'title' => 'Angioplasty & Stenting',
                'department_name' => 'Cardiology',
                'icon' => 'fa-heart-pulse',
                'short_description' => 'Minimally invasive procedure to open clogged heart arteries and restore blood flow.',
                'full_description' => 'Angioplasty (also called percutaneous coronary intervention) is a procedure used to open clogged heart arteries. It involves temporarily inserting and inflating a tiny balloon where your artery is clogged to help widen the artery. Angioplasty is often combined with the permanent placement of a small wire mesh tube called a stent to help prop the artery open and decrease its chance of narrowing again.',
                'price_from' => 1250.00,
                'duration' => '1 - 2 Hours',
                'recovery_time' => '1 - 2 Weeks',
                'benefits' => [
                    'Significantly improves blood flow to the heart muscle',
                    'Relieves chest pain (angina) and shortness of breath',
                    'Reduces risk of future myocardial infarction (heart attack)',
                    'Minimally invasive with rapid return to daily routines'
                ],
                'preparation' => [
                    'Do not eat or drink anything after midnight before the procedure.',
                    'Discuss all current medications and allergies with your cardiologist.',
                    'Arrange for a family member or friend to drive you home after discharge.'
                ],
                'procedure' => [
                    'Step 1: Local anesthesia is applied to the groin or wrist area.',
                    'Step 2: A catheter is guided through the blood vessels to the blocked coronary artery.',
                    'Step 3: A balloon is inflated to compress the plaque, and a stent is deployed to keep the artery open.'
                ],
                'faq' => [
                    ['question' => 'How long does a stent last?', 'answer' => 'Stents are designed to be permanent implants and last a lifetime.'],
                    ['question' => 'Will I need to stay in the hospital overnight?', 'answer' => 'Most patients stay overnight for monitoring and are discharged the next day.']
                ]
            ],
            [
                'title' => 'Coronary Artery Bypass Graft (CABG)',
                'department_name' => 'Cardiology',
                'icon' => 'fa-heart-pulse',
                'short_description' => 'Surgical procedure to bypass blocked coronary arteries, improving blood flow.',
                'full_description' => 'Coronary Artery Bypass Graft (CABG) is a major surgical procedure used to treat severe coronary heart disease. During CABG, a healthy blood vessel taken from another part of your body (usually the leg, arm, or chest) is connected to the blocked coronary artery. This creates a new pathway, bypassing the clogged section and delivering oxygen-rich blood directly to the heart muscle.',
                'price_from' => 4500.00,
                'duration' => '3 - 6 Hours',
                'recovery_time' => '6 - 8 Weeks',
                'benefits' => [
                    'Restores normal blood supply to the heart muscle',
                    'Relieves severe chest pain and chronic shortness of breath',
                    'Reduces the risk of severe heart failure or cardiac events',
                    'Significantly increases life expectancy in patients with severe disease'
                ],
                'preparation' => [
                    'Complete all scheduled pre-operative lab work and imaging tests.',
                    'Stop taking specific blood thinners under doctor direction.',
                    'Pack a bag with essentials for a hospital stay of 5 to 7 days.'
                ],
                'procedure' => [
                    'Step 1: General anesthesia is administered, and the chest cavity is opened.',
                    'Step 2: Healthy blood vessels are harvested from the leg or chest.',
                    'Step 3: The harvested vessels are grafted bypass the blocked coronary arteries.'
                ],
                'faq' => [
                    ['question' => 'Is CABG a safe surgery?', 'answer' => 'Yes, CABG is a highly routine surgery with success rates exceeding 95% at AarogyaCare.'],
                    ['question' => 'How long will I stay in the ICU?', 'answer' => 'Typically, patients spend 1 to 2 days in the ICU before moving to a regular ward room.']
                ]
            ],
            [
                'title' => 'Brain Tumor Resection',
                'department_name' => 'Neurology',
                'icon' => 'fa-brain',
                'short_description' => 'Advanced neurosurgical removal of benign or malignant brain tumors.',
                'full_description' => 'Brain tumor resection is a complex surgical procedure performed by our board-certified neurosurgeons to remove as much of a brain tumor as possible while preserving vital neurological functions. Using state-of-the-art navigation systems, intraoperative MRI, and microscopic technologies, our surgical team safely accesses and extracts tumor tissue to reduce pressure and guide further therapies.',
                'price_from' => 5800.00,
                'duration' => '4 - 8 Hours',
                'recovery_time' => '4 - 6 Weeks',
                'benefits' => [
                    'Relieves pressure within the skull, reducing headaches and seizures',
                    'Restores or preserves critical motor, sensory, and cognitive functions',
                    'Obtains tumor tissue for precise histological analysis and treatment mapping',
                    'Improves long-term survival rates and quality of life'
                ],
                'preparation' => [
                    'Undergo high-resolution brain mapping and MRI scans.',
                    'Begin prescribed medications to reduce brain swelling prior to surgery.',
                    'Arrange for dedicated care support at home during the initial recovery weeks.'
                ],
                'procedure' => [
                    'Step 1: General anesthesia is administered, and the head is secured.',
                    'Step 2: A craniotomy is performed to temporarily remove a section of bone from the skull.',
                    'Step 3: Microsurgical tools are used to safely remove the tumor tissue.'
                ],
                'faq' => [
                    ['question' => 'Are all brain tumors cancerous?', 'answer' => 'No, many tumors are benign (non-cancerous) but still require removal to prevent pressure on brain tissue.'],
                    ['question' => 'Will I have cognitive changes after surgery?', 'answer' => 'Some temporary changes can occur, but our neuro-rehabilitation team helps restore functions rapidly.']
                ]
            ],
            [
                'title' => 'Electroencephalogram (EEG)',
                'department_name' => 'Neurology',
                'icon' => 'fa-brain',
                'short_description' => 'Diagnostic test recording electrical activity of the brain to detect abnormalities.',
                'full_description' => 'An electroencephalogram (EEG) is a non-invasive diagnostic test that detects electrical activity in your brain using small, metal discs (electrodes) attached to your scalp. Your brain cells communicate via electrical impulses and are active all the time, even when you are asleep. This activity shows up as wavy lines on an EEG recording, allowing neurologists to diagnose conditions such as epilepsy, sleep disorders, and brain damage.',
                'price_from' => 150.00,
                'duration' => '1 - 2 Hours',
                'recovery_time' => 'Immediate',
                'benefits' => [
                    'Accurately diagnoses seizure types and epilepsy syndromes',
                    'Evaluates sleep-related neurological disorders and brain trauma',
                    'Provides objective data on brain health in a safe, non-invasive way',
                    'Helps monitor brain activity during critical care states'
                ],
                'preparation' => [
                    'Wash your hair the night before or the morning of the test, and do not use styling products.',
                    'Avoid caffeine for at least 8 hours prior to the EEG.',
                    'Follow specific sleep deprivation guidelines if requested by your physician.'
                ],
                'procedure' => [
                    'Step 1: Scalp measurements are taken to mark electrode placements.',
                    'Step 2: Electrodes are secured to the scalp using a special conductive paste.',
                    'Step 3: The patient relaxes while the machine records brainwave patterns during various stimuli.'
                ],
                'faq' => [
                    ['question' => 'Is the EEG test painful?', 'answer' => 'No, the electrodes only record brain signals and do not transmit any electricity to your body.'],
                    ['question' => 'Can I drive home after the test?', 'answer' => 'Yes, unless you had a sleep-deprived EEG or received a sedative, you can resume normal activities immediately.']
                ]
            ],
            [
                'title' => 'Total Knee Replacement',
                'department_name' => 'Orthopedics',
                'icon' => 'fa-bone',
                'short_description' => 'Reconstruction surgery replacing damaged joint surfaces with biocompatible implants.',
                'full_description' => 'Total knee replacement, or knee arthroplasty, is a highly effective surgical procedure to resurface a knee damaged by severe arthritis or injury. Metal and plastic parts are used to cap the ends of the bones that form the knee joint, along with the kneecap. This surgery helps relieve chronic pain, improve joint alignment, and restore mobility to patients seeking to return to an active lifestyle.',
                'price_from' => 3200.00,
                'duration' => '1 - 2 Hours',
                'recovery_time' => '4 - 6 Weeks',
                'benefits' => [
                    'Completely eliminates or dramatically reduces chronic arthritic joint pain',
                    'Restores knee joint alignment and stability',
                    'Enables returns to daily walking, climbing, and low-impact sports',
                    'Implants have a durability design lasting 15 to 20 years'
                ],
                'preparation' => [
                    'Attend pre-operative physiotherapy sessions to build leg muscle strength.',
                    'Set up your home with rails, shower chairs, and clear paths before surgery.',
                    'Complete a dental check-up to rule out any potential sources of systemic infection.'
                ],
                'procedure' => [
                    'Step 1: Spinal or general anesthesia is administered.',
                    'Step 2: Damaged bone ends and cartilage are removed from the femur and tibia.',
                    'Step 3: Biocompatible metal and high-density plastic components are secured to restore joint mobility.'
                ],
                'faq' => [
                    ['question' => 'How soon can I walk after surgery?', 'answer' => 'With the help of crutches or a walker, most patients start walking on the first day after surgery.'],
                    ['question' => 'Will I need outpatient physiotherapy?', 'answer' => 'Yes, a structured physical therapy plan for 4 to 6 weeks is crucial for optimal joint recovery.']
                ]
            ],
            [
                'title' => 'Spinal Fusion Surgery',
                'department_name' => 'Orthopedics',
                'icon' => 'fa-bone',
                'short_description' => 'Surgical joining of two or more vertebrae to restore spinal stability.',
                'full_description' => 'Spinal fusion is a surgical procedure used to connect two or more vertebrae in your spine permanently, eliminating motion between them. This procedure mimics the natural healing process of broken bones. During spinal fusion, our spine surgeons use bone grafts and supportive metal hardware (screws, rods, and cages) to lock the vertebrae together, treating instability, severe disc degeneration, or spinal deformities.',
                'price_from' => 4800.00,
                'duration' => '2 - 4 Hours',
                'recovery_time' => '8 - 12 Weeks',
                'benefits' => [
                    'Stabilizes the spine, preventing painful movement between vertebrae',
                    'Decompresses compressed spinal nerves, relieving shooting leg pain',
                    'Corrects spinal deformities such as scoliosis or spondylolisthesis',
                    'Improves posture and physical capabilities'
                ],
                'preparation' => [
                    'Stop smoking, as nicotine interferes with bone fusion healing.',
                    'Obtain clearance from your cardiologist or primary care doctor.',
                    'Arrange for help at home since bending, lifting, and twisting will be restricted.'
                ],
                'procedure' => [
                    'Step 1: The surgeon makes an incision to access the spine from the back or abdomen.',
                    'Step 2: Damaged spinal discs are removed and replaced with a bone graft or cage.',
                    'Step 3: Screws and rods are placed to secure the vertebrae until they fuse together.'
                ],
                'faq' => [
                    ['question' => 'How long does the bone take to fuse?', 'answer' => 'Complete bone fusion takes 3 to 6 months, but you can return to light activities much sooner.'],
                    ['question' => 'Will I lose spinal flexibility?', 'answer' => 'Most patients feel minimal loss in overall mobility because other areas of the spine compensate for the fused section.']
                ]
            ],
            [
                'title' => 'Pediatric Asthma Management',
                'department_name' => 'Pediatrics',
                'icon' => 'fa-stethoscope',
                'short_description' => 'Comprehensive diagnosis, personalized action plans, and therapy for child asthma.',
                'full_description' => 'Our Pediatric Asthma Management program focuses on providing children and their families with the tools, medication plans, and education needed to control asthma symptoms. Led by pediatric pulmonologists, we diagnose childhood asthma using age-appropriate lung function tests, identify environmental triggers, and build step-by-step action plans to prevent acute flare-ups and ensure children can play and learn without breathing restrictions.',
                'price_from' => 120.00,
                'duration' => '45 Mins',
                'recovery_time' => 'Ongoing',
                'benefits' => [
                    'Dramatically reduces emergency room visits and hospital admissions',
                    'Creates a clear, customized Asthma Action Plan for home and school',
                    'Minimizes daily symptoms like coughing, wheezing, and chest tightness',
                    'Optimizes child growth, sleep patterns, and physical play'
                ],
                'preparation' => [
                    'Keep a 7-day diary of your child’s symptoms and potential triggers before the visit.',
                    'Bring all inhalers, spacers, and current medicine to the clinic.',
                    'Avoid using bronchodilators for 4-6 hours if lung function testing is scheduled.'
                ],
                'procedure' => [
                    'Step 1: Detailed pediatric history and physical exam are conducted.',
                    'Step 2: Spirometry or peak flow testing is performed to assess airway resistance.',
                    'Step 3: Trigger education, inhaler technique check, and medication plans are delivered.'
                ],
                'faq' => [
                    ['question' => 'Can my child outgrow asthma?', 'answer' => 'Many children experience symptom improvements as their lungs grow, but proper management remains essential.'],
                    ['question' => 'How often should we review the action plan?', 'answer' => 'We recommend reviewing the asthma action plan every 3 to 6 months, or after any severe flare-up.']
                ]
            ],
            [
                'title' => 'Neonatal Intensive Care (NICU)',
                'department_name' => 'Pediatrics',
                'icon' => 'fa-stethoscope',
                'short_description' => 'Critical care support for premature, low birth weight, and sick newborns.',
                'full_description' => 'The Neonatal Intensive Care Unit (NICU) at AarogyaCare is a state-of-the-art department dedicated to caring for premature, low birth weight, or critically ill infants. Staffed by neonatologists, neonatal nurses, and therapists, our NICU provides round-the-clock intensive care, advanced respiratory support, temperature-controlled incubators, and specialized nutritional plans to help our youngest patients grow and thrive in a safe environment.',
                'price_from' => 600.00,
                'duration' => 'Ongoing',
                'recovery_time' => 'Varies',
                'benefits' => [
                    'Provides 24x7 monitoring and life-support intervention by neonatology experts',
                    'Utilizes advanced respiratory tech, including high-frequency ventilators',
                    'Supports developmental care, parent bonding, and skin-to-skin therapy',
                    'Monitors and secures infant developmental milestones'
                ],
                'preparation' => [
                    'Meet with the neonatology team if a high-risk delivery is anticipated.',
                    'Ensure all family members are educated on strict hand hygiene rules before visiting.',
                    'Coordinate breast milk collection plans with our lactation consultants.'
                ],
                'procedure' => [
                    'Step 1: Infant is stabilized in the delivery room and transferred to the NICU.',
                    'Step 2: Non-invasive or invasive monitoring, IV access, and feeding plans are established.',
                    'Step 3: Continuous specialist rounds and therapy updates are shared with parents daily.'
                ],
                'faq' => [
                    ['question' => 'Can parents visit the NICU anytime?', 'answer' => 'Yes, parents have 24-hour access to their infant in the NICU, with minor restrictions during nurse handovers.'],
                    ['question' => 'How long will my baby need to stay in the NICU?', 'answer' => 'Discharge is typically planned close to the baby’s original due date, once they can breathe, feed, and hold temperature on their own.']
                ]
            ],
            [
                'title' => 'Chemotherapy Treatment',
                'department_name' => 'Oncology',
                'icon' => 'fa-kit-medical',
                'short_description' => 'Targeted administration of anti-cancer drugs to destroy malignant cancer cells.',
                'full_description' => 'Chemotherapy is a systemic medical treatment using powerful drugs to target and destroy rapidly dividing cancer cells throughout the body. Administered in our premium daycare oncology suites, chemotherapy plans are tailored by medical oncologists based on cancer type, staging, and genetic markers. We prioritize patient comfort, safety, and symptom control with dedicated support teams and clean, calming surroundings.',
                'price_from' => 350.00,
                'duration' => '2 - 6 Hours',
                'recovery_time' => '1 - 2 Weeks',
                'benefits' => [
                    'Destroys cancer cells, preventing growth and metastatic spread',
                    'Shrinks tumors prior to surgery (neoadjuvant chemotherapy)',
                    'Eliminates remaining microscopic cancer cells after surgery (adjuvant therapy)',
                    'Provides palliative care to relieve symptoms in advanced stages'
                ],
                'preparation' => [
                    'Obtain scheduled pre-chemo blood tests to verify liver, kidney, and bone marrow health.',
                    'Have a light meal before arriving for your infusion session.',
                    'Ensure your vascular access device (port-a-cath) is checked and flushed.'
                ],
                'procedure' => [
                    'Step 1: Vital signs are recorded and pre-meds (anti-nausea) are administered.',
                    'Step 2: The chemotherapy drugs are prepared and infused through an IV or vascular port.',
                    'Step 3: Post-treatment monitoring is conducted before patient is discharged home.'
                ],
                'faq' => [
                    ['question' => 'Will I lose my hair?', 'answer' => 'Hair loss depends on the specific drugs used; your oncologist will discuss scalp cooling therapies to minimize loss.'],
                    ['question' => 'How many cycles of chemo will I need?', 'answer' => 'Most chemotherapy plans consist of 4 to 8 cycles, spread over 3 to 6 months.']
                ]
            ],
            [
                'title' => 'Radiation Therapy',
                'department_name' => 'Oncology',
                'icon' => 'fa-kit-medical',
                'short_description' => 'High-precision radiation beams directed at tumors to destroy cancer cells.',
                'full_description' => 'Radiation therapy utilizes high-energy X-rays, gamma rays, or charged particles to damage the DNA of cancer cells, preventing them from dividing and growing. Our radiation oncology department features linear accelerators with advanced targeting techniques (IMRT, SBRT) to focus radiation precisely on the tumor while protecting the surrounding healthy organs and tissues.',
                'price_from' => 450.00,
                'duration' => '15 - 30 Mins',
                'recovery_time' => 'Minimal',
                'benefits' => [
                    'Highly targeted treatment that localized to the tumor site',
                    'Non-invasive procedure with no surgical incisions or anesthesia required',
                    'Can be combined effectively with chemotherapy and surgery',
                    'Excellent option for treating tumors in complex anatomical locations'
                ],
                'preparation' => [
                    'Attend a radiation simulation session to mark the exact treatment fields on your skin.',
                    'Follow custom skin care instructions to prepare the treatment site.',
                    'Drink plenty of water to maintain hydration levels before each session.'
                ],
                'procedure' => [
                    'Step 1: The patient is positioned on the treatment table using custom molds or stabilizers.',
                    'Step 2: Imaging scans verify alignment with the simulation marks.',
                    'Step 3: The linear accelerator rotates to deliver precise radiation beams.'
                ],
                'faq' => [
                    ['question' => 'Does radiation therapy make me radioactive?', 'answer' => 'No, external beam radiation does not leave any radiation in your body, and it is safe to be around others.'],
                    ['question' => 'What are the side effects?', 'answer' => 'Common side effects include mild fatigue and localized skin irritation, similar to a sunburn.']
                ]
            ],
            [
                'title' => 'Magnetic Resonance Imaging (MRI)',
                'department_name' => 'Radiology',
                'icon' => 'fa-x-ray',
                'short_description' => 'High-resolution imaging using strong magnetic fields to visualize internal structures.',
                'full_description' => 'Magnetic Resonance Imaging (MRI) is a diagnostic technique that uses strong magnetic fields and radio waves to generate detailed, three-dimensional images of the organs and tissues within your body. MRI is particularly useful for imaging the brain, spinal cord, muscles, ligaments, and soft tissues. Our facility features wide-bore silent MRI systems that maximize patient comfort and reduce anxiety.',
                'price_from' => 180.00,
                'duration' => '30 - 60 Mins',
                'recovery_time' => 'Immediate',
                'benefits' => [
                    'Provides exceptional soft tissue contrast without ionizing radiation',
                    'Detects small structural abnormalities, joint damage, and neurological lesions',
                    'Enables early diagnosis of strokes, tumors, and cardiovascular issues',
                    'Silent wide-bore technology minimizes claustrophobia'
                ],
                'preparation' => [
                    'Remove all jewelry, metal accessories, hairpins, and body piercings.',
                    'Inform the technician if you have a pacemaker, cochlear implant, or metallic joint replacements.',
                    'Provide details on kidney health if a contrast agent is ordered.'
                ],
                'procedure' => [
                    'Step 1: The patient lies down on a sliding table.',
                    'Step 2: Earplugs or headphones are provided to block the scanner sounds.',
                    'Step 3: The table moves into the scanner, and the imaging sequence is completed.'
                ],
                'faq' => [
                    ['question' => 'Why does the MRI machine make loud noises?', 'answer' => 'The thumping sounds are caused by the rising and falling electrical currents in the scanner coils generating the magnetic field.'],
                    ['question' => 'Can I get an MRI if I am pregnant?', 'answer' => 'MRI is generally safe during pregnancy, but we take extra precautions and consult with your obstetrician first.']
                ]
            ],
            [
                'title' => 'Computed Tomography (CT) Scan',
                'department_name' => 'Radiology',
                'icon' => 'fa-x-ray',
                'short_description' => 'Cross-sectional X-ray imaging for rapid diagnosis of internal injuries and diseases.',
                'full_description' => 'A Computed Tomography (CT) scan combines a series of X-ray images taken from different angles around your body and uses computer processing to create cross-sectional slices of the bones, blood vessels, and soft tissues. CT scans offer fast, highly detailed information and are critical in emergency medicine to assess internal injuries, detect blood clots, locate infections, and guide biopsies.',
                'price_from' => 140.00,
                'duration' => '15 - 30 Mins',
                'recovery_time' => 'Immediate',
                'benefits' => [
                    'Extremely fast scan times, ideal for emergency triage and trauma assessment',
                    'Generates clear images of bone, soft tissue, and blood vessels simultaneously',
                    'Aids in the detection and staging of cancers, cardiovascular disease, and bone fractures',
                    'Saves critical time in stroke diagnosis and treatment plans'
                ],
                'preparation' => [
                    'Avoid eating or drinking for 2-4 hours before the scan if contrast dye is used.',
                    'Wear comfortable, loose clothing and leave metal objects at home.',
                    'Let our team know if you are pregnant or have a history of contrast allergy.'
                ],
                'procedure' => [
                    'Step 1: The patient lies on a motorized table that slides through a circular scanner.',
                    'Step 2: An IV line is placed if contrast dye is required for the scan.',
                    'Step 3: The scanner rotates around the patient to capture cross-sectional images.'
                ],
                'faq' => [
                    ['question' => 'What does the contrast dye feel like?', 'answer' => 'You may feel a warm flush or a metallic taste in your mouth when the dye is injected, which fades quickly.'],
                    ['question' => 'Are CT scans safe regarding radiation?', 'answer' => 'Yes, our modern CT scanners use ultra-low-dose technology to minimize radiation while maintaining image quality.']
                ]
            ],
            [
                'title' => 'Trauma & Emergency Care',
                'department_name' => 'Emergency',
                'icon' => 'fa-kit-medical',
                'short_description' => 'Immediate life-saving care and triage for acute injuries, strokes, and heart attacks.',
                'full_description' => 'Our Trauma and Emergency Care department provides 24x7 immediate, life-saving medical attention to patients with critical illness, severe injuries, or acute medical emergencies. Staffed by board-certified emergency physicians and trauma specialists, our emergency department includes dedicated resuscitation bays, priority radiology access, and immediate link-up with our cardiology and neurosurgery teams.',
                'price_from' => 200.00,
                'duration' => 'Varies',
                'recovery_time' => 'Varies',
                'benefits' => [
                    'Immediate triage and clinical intervention for life-threatening emergencies',
                    'Dedicated chest pain and stroke response teams for rapid outcomes',
                    'Advanced life support, airway management, and trauma stabilization',
                    'On-site ICU and surgery coordination 24 hours a day'
                ],
                'preparation' => [
                    'No preparation is needed; immediately call emergency or report to the ER bay.',
                    'If possible, bring previous prescriptions or medical cards.',
                    'Have an emergency contact name and number ready.'
                ],
                'procedure' => [
                    'Step 1: Immediate triage assessment categorizes case severity on arrival.',
                    'Step 2: Resuscitation and primary diagnostics are conducted in the ER bay.',
                    'Step 3: Admission, emergency surgery, or stabilization therapy is executed.'
                ],
                'faq' => [
                    ['question' => 'How are patients prioritized in the ER?', 'answer' => 'Patients are seen based on clinical severity, not order of arrival, to ensure critical cases receive instant care.'],
                    ['question' => 'Do you coordinate ambulance pickups?', 'answer' => 'Yes, our 24x7 ambulance dispatch can be requested by calling our emergency line.']
                ]
            ],
            [
                'title' => 'Ambulance Triage Care',
                'department_name' => 'Emergency',
                'icon' => 'fa-kit-medical',
                'short_description' => 'Critical pre-hospital medical response, transport, and stabilization.',
                'full_description' => 'Ambulance Triage Care covers our advanced pre-hospital emergency medical service. Equipped with state-of-the-art life support systems, ventilators, ECG machines, and trauma stabilization kits, our mobile ICU ambulances are staffed by critical care paramedics and emergency technicians to begin treatment and transmit vital data to our ER doctors while in transit.',
                'price_from' => 100.00,
                'duration' => 'Transit Time',
                'recovery_time' => 'Immediate',
                'benefits' => [
                    'Critical pre-hospital stabilization for strokes, cardiac events, and major trauma',
                    'Equipped with advanced cardiac monitors and airway support systems',
                    'Direct telemetry links to ER team for immediate preparation of the hospital room',
                    'Fast, priority route navigation by trained emergency drivers'
                ],
                'preparation' => [
                    'Call our emergency number (+91 1800 123 456) and specify patient state and location.',
                    'Keep roads and gates clear for the ambulance entry.',
                    'Gather key patient IDs and medical records to take with you.'
                ],
                'procedure' => [
                    'Step 1: Paramediic team conducts primary assessment and stabilizes patient.',
                    'Step 2: Emergency treatment is started (IV access, oxygen, cardiac monitoring).',
                    'Step 3: Telemetry data is sent to AarogyaCare ER while driving to the hospital.'
                ],
                'faq' => [
                    ['question' => 'Is the ambulance service active in all areas?', 'answer' => 'Our service covers the entire city and surrounding metropolitan areas 24x7.'],
                    ['question' => 'Does the ambulance have critical care doctors on board?', 'answer' => 'Yes, for complex cardiac or neonatal transports, we dispatch a specialized medical team.']
                ]
            ],
            [
                'title' => 'Laser Dermatology Treatment',
                'department_name' => 'Dermatology',
                'icon' => 'fa-stethoscope',
                'short_description' => 'Advanced laser therapies for vascular lesions, scarring, and skin rejuvenation.',
                'full_description' => 'Our Laser Dermatology Treatment program utilizes medical-grade laser systems (CO2 fractional, Nd:YAG, and Q-switched lasers) to treat a variety of dermatological conditions. Under the care of board-certified dermatologists, these treatments target pigmentary lesions, vascular anomalies, acne scars, and signs of skin aging by stimulating collagen production and safely resurfacing damaged skin layers.',
                'price_from' => 150.00,
                'duration' => '30 - 60 Mins',
                'recovery_time' => '3 - 7 Days',
                'benefits' => [
                    'Highly precise skin targeting with minimal damage to adjacent tissue',
                    'Reduces scars, dark spots, and improves overall skin texture',
                    'Stimulates deep collagen synthesis for long-term skin health',
                    'Safe outpatient procedure with minimal downtime'
                ],
                'preparation' => [
                    'Avoid direct sun exposure and tanning beds for 2 weeks prior to treatment.',
                    'Discontinue use of retinoids and exfoliating acids 5 days before your session.',
                    'Arrive with clean skin, free from makeup, lotions, or perfume.'
                ],
                'procedure' => [
                    'Step 1: The skin is cleansed, and a topical numbing cream is applied.',
                    'Step 2: Protective eyewear is secured, and the laser settings are adjusted.',
                    'Step 3: Laser pulses are directed at the target skin areas, followed by a cooling gel application.'
                ],
                'faq' => [
                    ['question' => 'Does laser treatment hurt?', 'answer' => 'Most patients feel a warm snapping sensation; the topical numbing cream helps ensure a comfortable session.'],
                    ['question' => 'How many sessions will I need?', 'answer' => 'Depending on the skin condition, most patients see optimal results after 3 to 5 sessions.']
                ]
            ],
            [
                'title' => 'Tympanoplasty (Eardrum Repair)',
                'department_name' => 'ENT',
                'icon' => 'fa-ear-listen',
                'short_description' => 'Surgical reconstruction of a perforated eardrum to restore hearing and prevent infection.',
                'full_description' => 'Tympanoplasty is a surgical procedure performed by our ENT specialists to repair a hole or tear in the tympanic membrane (eardrum). A perforated eardrum can lead to recurrent ear infections and significant hearing loss. During tympanoplasty, the surgeon uses a small graft of tissue from the patient\'s body to seal the perforation, restoring the ear\'s natural protection and improving hearing performance.',
                'price_from' => 1800.00,
                'duration' => '1 - 2 Hours',
                'recovery_time' => '1 - 2 Weeks',
                'benefits' => [
                    'Seals the eardrum, preventing water and bacteria from causing chronic infections',
                    'Significantly improves conductive hearing loss',
                    'Relieves chronic ear discharge and discomfort',
                    'Improves patient safety in water-related activities after recovery'
                ],
                'preparation' => [
                    'Avoid getting water in the affected ear prior to surgery by using earplugs.',
                    'Complete scheduled pre-operative hearing tests (audiograms).',
                    'Notify your surgeon of any signs of cold or active ear infection before the procedure.'
                ],
                'procedure' => [
                    'Step 1: The patient is anesthetized, and an incision is made behind the ear or inside the canal.',
                    'Step 2: A tissue graft is harvested and carefully positioned under the eardrum perforation.',
                    'Step 3: Packing material is placed in the ear canal to support the graft during healing.'
                ],
                'faq' => [
                    ['question' => 'Will I need to stay in the hospital?', 'answer' => 'Tympanoplasty is typically performed as an outpatient procedure, allowing you to return home the same day.'],
                    ['question' => 'When can I travel by plane after surgery?', 'answer' => 'We recommend waiting at least 4 to 6 weeks before flying to avoid pressure changes in the ear.']
                ]
            ],
            [
                'title' => 'Cochlear Implant Surgery',
                'department_name' => 'ENT',
                'icon' => 'fa-ear-listen',
                'short_description' => 'Electronic device implantation to restore functional hearing for severe hearing loss.',
                'full_description' => 'Cochlear implant surgery involves placing an electronic medical device that bypasses damaged parts of the inner ear (cochlea) to directly stimulate the auditory nerve. Unlike hearing aids, which make sounds louder, cochlear implants send signals directly to the brain. This procedure is designed for adults and children with severe to profound sensorineural hearing loss who receive limited benefit from hearing aids.',
                'price_from' => 6500.00,
                'duration' => '2 - 3 Hours',
                'recovery_time' => '3 - 4 Weeks',
                'benefits' => [
                    'Restores the ability to perceive sounds and understand speech in various environments',
                    'Significantly improves communication capabilities and social interaction',
                    'Enables children with hearing loss to develop spoken language skills',
                    'Enhances personal safety through awareness of environmental alerts'
                ],
                'preparation' => [
                    'Undergo comprehensive audiological and CT/MRI imaging evaluations.',
                    'Receive scheduled vaccinations to reduce post-implant meningitis risks.',
                    'Align with an auditory-verbal therapist for post-activation rehabilitation plans.'
                ],
                'procedure' => [
                    'Step 1: General anesthesia is administered, and an incision is made behind the ear.',
                    'Step 2: The internal receiver-stimulator is secured in a bone bed, and the electrode array is guided into the cochlea.',
                    'Step 3: Device functionality is verified, and the incision is closed.'
                ],
                'faq' => [
                    ['question' => 'Will I hear immediately after surgery?', 'answer' => 'No, hearing is restored 3 to 4 weeks later during the activation and mapping session with your audiologist.'],
                    ['question' => 'Can a cochlear implant be used in both ears?', 'answer' => 'Yes, many patients benefit from bilateral cochlear implants to improve sound localization.']
                ]
            ],
            [
                'title' => 'Cesarean Section (C-Section)',
                'department_name' => 'Gynecology',
                'icon' => 'fa-bed-pulse',
                'short_description' => 'Surgical delivery of a baby through incisions in the mother\'s abdomen and uterus.',
                'full_description' => 'A Cesarean section, or C-section, is the surgical delivery of a baby through incisions made in the mother’s abdomen and uterus. C-sections may be planned in advance due to medical indications, or they may be performed unexpectedly during labor when complications arise. Our maternity team ensures a safe, supportive, and clean environment for both mother and newborn during surgical delivery.',
                'price_from' => 2200.00,
                'duration' => '45 - 60 Mins',
                'recovery_time' => '4 - 6 Weeks',
                'benefits' => [
                    'Secures safe delivery when vaginal birth poses risks to mother or baby',
                    'Avoids labor complications in cases of breach presentation or placenta previa',
                    'Allows planned scheduling of delivery under controlled medical conditions',
                    'Immediate post-delivery neonatal support on-site'
                ],
                'preparation' => [
                    'Complete scheduled pre-operative lab work and blood typing.',
                    'Fast from food and drink for 8 hours prior to a planned C-section.',
                    'Prepare a birth plan and packs for a hospital stay of 3 to 4 days.'
                ],
                'procedure' => [
                    'Step 1: Regional anesthesia (spinal or epidural) is administered, numbing the lower body.',
                    'Step 2: Incisions are made in the lower abdomen and uterus to gently deliver the baby.',
                    'Step 3: The placenta is removed, and the uterine and abdominal incisions are sutured.'
                ],
                'faq' => [
                    ['question' => 'Will I be awake during the C-section?', 'answer' => 'Yes, spinal anesthesia allows you to remain awake to see your baby immediately, without feeling pain.'],
                    ['question' => 'Can my partner be in the operating room?', 'answer' => 'Yes, in most planned C-sections, partners are welcome in the operating room to support the mother.']
                ]
            ],
            [
                'title' => 'Kidney Stone Laser Treatment',
                'department_name' => 'Urology',
                'icon' => 'fa-stethoscope',
                'short_description' => 'Laser lithotripsy to fragment and remove kidney stones in a minimally invasive way.',
                'full_description' => 'Kidney stone laser treatment, or laser lithotripsy, is a minimally invasive procedure to treat kidney stones. During the procedure, a urologist passes a small lighted scope (ureteroscope) through the urethra and bladder into the ureter to locate the stone. A tiny laser fiber is then used to transmit laser energy to break the stone into tiny pieces, which are either removed with a basket or pass naturally in urine.',
                'price_from' => 1600.00,
                'duration' => '1 - 2 Hours',
                'recovery_time' => '3 - 5 Days',
                'benefits' => [
                    'Minimally invasive procedure with no surgical incisions required',
                    'Direct laser visualization ensures precise fragmenting of the stone',
                    'Excellent success rates for removing stones located in the ureter or kidney',
                    'Rapid recovery allowing return to work within a few days'
                ],
                'preparation' => [
                    'Undergo a CT scan to map the exact size and location of the kidney stones.',
                    'Fast for 8 hours prior to the procedure as general or spinal anesthesia is used.',
                    'Increase water intake to prepare kidneys for post-procedure clearance.'
                ],
                'procedure' => [
                    'Step 1: Spinal or general anesthesia is administered to the patient.',
                    'Step 2: The ureteroscope is guided through the urinary tract to the stone.',
                    'Step 3: A laser fiber breaks the stone, and a temporary ureteral stent may be placed to aid healing.'
                ],
                'faq' => [
                    ['question' => 'Is a stent always necessary?', 'answer' => 'A temporary stent is often placed for a few days to prevent swelling and help stone dust pass easily.'],
                    ['question' => 'How can I prevent future kidney stones?', 'answer' => 'Our urology clinic provides personalized dietary plans and hydration targets based on stone analysis.']
                ]
            ],
            [
                'title' => 'Critical Care Ventilation',
                'department_name' => 'ICU',
                'icon' => 'fa-bed-pulse',
                'short_description' => 'Life-support respiratory ventilation and monitoring for critically ill patients.',
                'full_description' => 'Critical Care Ventilation involves providing advanced mechanical breathing support to patients in our Intensive Care Unit (ICU) who are experiencing respiratory failure. Using high-specification ventilators, our critical care teams closely monitor blood gases, airway pressures, and oxygenation levels to manage lung conditions like ARDS, severe pneumonia, or multi-organ dysfunction.',
                'price_from' => 800.00,
                'duration' => 'Ongoing',
                'recovery_time' => 'Varies',
                'benefits' => [
                    'Maintains oxygen levels and supports breathing in cases of acute lung injury',
                    'Allows the respiratory muscles to rest and recover during critical illness',
                    'Continuously monitored by dedicated intensive care specialists',
                    'Integrates with advanced clinical pharmacology and nutrition plans'
                ],
                'preparation' => [
                    'ICU ventilation is typically an emergency setup; no patient preparation is possible.',
                    'Consent and updates are handled directly with close family members.',
                    'Family briefing schedules are established with the ICU lead.'
                ],
                'procedure' => [
                    'Step 1: Patient airway is secured through intubation or a tracheostomy tube.',
                    'Step 2: The ventilator settings are configured based on patient lung mechanics and blood gas targets.',
                    'Step 3: Continuous assessment and gradual weaning trials are conducted daily by specialists.'
                ],
                'faq' => [
                    ['question' => 'Can a patient speak while on a ventilator?', 'answer' => 'No, the breathing tube passes through the vocal cords, preventing speech. We use writing boards and gestures for communication.'],
                    ['question' => 'How do you prevent lung infections during ventilation?', 'answer' => 'Our ICU follows strict infection control bundles, including elevate head positioning and sterile suctioning protocols.']
                ]
            ]
        ];

        foreach ($servicesData as $data) {
            $department = Department::query()->where('name', $data['department_name'])->first();

            // Fallback if department doesn't exist
            if (!$department) {
                $department = Department::query()->create([
                    'name' => $data['department_name'],
                    'slug' => Str::slug($data['department_name']),
                    'description' => "Advanced specialty care in {$data['department_name']}.",
                    'icon' => $data['icon']
                ]);
            }

            Service::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'department_id' => $department->id,
                    'icon' => $data['icon'],
                    'short_description' => $data['short_description'],
                    'full_description' => $data['full_description'],
                    'price_from' => $data['price_from'],
                    'duration' => $data['duration'],
                    'recovery_time' => $data['recovery_time'],
                    'benefits' => $data['benefits'],
                    'preparation' => $data['preparation'],
                    'procedure' => $data['procedure'],
                    'faq' => $data['faq'],
                    'featured_image' => 'public/images/hospital.png',
                    'banner_image' => 'public/images/hospital.png',
                    'status' => 'active',
                    'meta_title' => $data['title'] . ' | AarogyaCare Services',
                    'meta_description' => $data['short_description']
                ]
            );
        }
    }
}
