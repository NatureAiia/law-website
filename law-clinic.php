<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$page = 'law-clinic';
$page_title = 'The Law Clinic';
include __DIR__ . '/includes/header.php';
?>

<div class="hero">
  <div class="container">
    <h1>The Law Clinic</h1>
    <p class="lead">The Africa University Law Clinic puts legal knowledge into action — serving communities through direct legal assistance, public legal awareness, and hands-on outreach led by our students under the supervision of qualified faculty.</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <p>The Law Clinic is where classroom learning becomes real service. Under the close supervision of experienced faculty, our law students assist members of the public who might otherwise struggle to access legal advice — helping them understand their rights, prepare basic documents, and navigate processes that can feel confusing or intimidating from the outside. Every case handled through the Clinic is reviewed by supervising staff before any advice is given, so that community members receive guidance that is both practical and sound, while students gain the kind of applied experience that no lecture hall can fully replicate.</p>
    <p>Much of the Clinic's work reaches beyond the university gates. Student teams regularly travel to surrounding rural and peri-urban communities to hold outreach sessions, listen to residents' concerns, and connect people with the help they need — whether that means a referral, a completed form, or simply a clearer understanding of a legal process. This community-facing focus is central to the Clinic's mission: legal knowledge is most valuable when it is shared, not kept behind office doors.</p>
    <p>None of this happens alone. The Clinic partners with local NGOs and community-based organisations to run legal awareness workshops on topics such as land rights, family law, and access to justice. These partnerships allow us to reach more people, tailor our sessions to real community needs, and build lasting relationships with the communities we serve.</p>
  </div>

  <div class="container">
    <div class="stats-strip">
      <div class="grid grid-3">
        <div>
          <div class="stat-number">150+</div>
          <div class="stat-label">Community Members Assisted</div>
        </div>
        <div>
          <div class="stat-number">12</div>
          <div class="stat-label">Outreach Workshops Held</div>
        </div>
        <div>
          <div class="stat-number">3</div>
          <div class="stat-label">Partner Communities</div>
        </div>
      </div>
    </div>
    <p class="text-center"><em>Figures are illustrative and will be updated as the Clinic's programme grows.</em></p>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <h2 class="text-center">What We Help With</h2>
    <div class="grid grid-3">
      <div class="card card-service">
        <h3>Family Law &amp; Domestic Relations</h3>
        <p>Guidance on maintenance claims, child custody, divorce processes, and applications for protection orders.</p>
      </div>
      <div class="card card-service">
        <h3>Land, Housing &amp; Property Rights</h3>
        <p>Support with communal and rural land tenure disputes, tenant rights, and guidance for those facing eviction.</p>
      </div>
      <div class="card card-service">
        <h3>Human Rights &amp; Constitutional Matters</h3>
        <p>Assistance for individuals affected by rights violations, and advocacy to improve access to justice.</p>
      </div>
      <div class="card card-service">
        <h3>Health-Related Legal Issues</h3>
        <p>Legal support connected to HIV/AIDS-status discrimination, patient rights, and access to healthcare.</p>
      </div>
      <div class="card card-service">
        <h3>Consumer &amp; Small Claims</h3>
        <p>Help with small debt disputes and complaints relating to unfair trade practices.</p>
      </div>
      <div class="card card-service">
        <h3>Community Legal Education &amp; Rural Outreach</h3>
        <p>Workshops and awareness campaigns delivered together with our NGO partners in rural and community settings.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" id="legal-help-form">
  <div class="container">
    <h2>Need Legal Help?</h2>
    <p>Members of the community who may need legal assistance are welcome to submit a request below. Every submission is reviewed by the Law Clinic team, who will follow up with you directly about the next steps.</p>

    <form method="post" action="<?= h(BASE_URL) ?>/law-clinic-submit.php">
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" class="form-control" maxlength="120" required>
      </div>
      <div class="form-group">
        <label for="contact_info">Contact Information</label>
        <input type="text" id="contact_info" name="contact_info" class="form-control" maxlength="150" placeholder="Phone number or email" required>
      </div>
      <div class="form-group">
        <label for="issue_category">Issue Category</label>
        <select id="issue_category" name="issue_category" class="form-control" required>
          <?php foreach (LEGAL_HELP_CATEGORIES as $cat): ?>
            <option value="<?= h($cat) ?>"><?= h($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="description">Describe Your Issue</label>
        <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-accent">Submit Request</button>
    </form>

    <div class="divider"></div>

    <h3>Prefer to Reach Us Directly?</h3>
    <div class="grid grid-2">
      <div class="card">
        <h4>Old Mutare Main Campus</h4>
        <p>Phone: +263 8688002151<br>Email: info@africau.edu</p>
      </div>
      <div class="card">
        <h4>Harare Global Campus</h4>
        <p>Phone: +263 778879492<br>Email: globalcampus@africau.edu</p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
